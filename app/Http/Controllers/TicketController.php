<?php

namespace App\Http\Controllers;

use App\Models\SiteRole;
use App\Models\SiteTicketDepartment;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserTicket;
use App\Models\UserTicketReply;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TicketController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function List_open(Request $request)
    {

        $ticket = UserTicket::latest();

        $count_ticket_open = UserTicket::latest();
        $count_ticket_high = UserTicket::latest();
        $count_ticket_low = UserTicket::latest();
        $count_ticket_medium = UserTicket::latest();
        $count_ticket_overdue = UserTicket::latest();

        $count_ticket_open->where('status_id', '!=', 4)->omniFilter();
        $count_ticket_high->where('status_id', 1)->where('Priority', 'High')->omniFilter();
        $count_ticket_low->where('status_id', 1)->where('Priority', 'Low')->omniFilter();
        $count_ticket_medium->where('status_id', 1)->where('Priority', 'Medium')->omniFilter();
        $count_ticket_overdue->where('status_id', '!=', '4')->whereRaw('due_date < CURDATE()')->omniFilter();

        if ($request->department) {
            $ticket->where('department_id', $request->department);
            $count_ticket_open->where('department_id', $request->department);
            $count_ticket_high->where('department_id', $request->department);
            $count_ticket_low->where('department_id', $request->department);
            $count_ticket_medium->where('department_id', $request->department);
            $count_ticket_overdue->where('department_id', $request->department);
        }

        $ticket->where('status_id', '!=', '4');

        $ticket->join('ticket_status', 'ticket_status.id', '=', 'user_ticket.status_id');
        $ticket->join('site_ticket_department', 'site_ticket_department.id', '=', 'user_ticket.department_id');

        $ticket->select('user_ticket.id', 'user_ticket.ticket_number', 'due_date', 'close_date', 'user_ticket.customer_name', 'user_ticket.title', 'user_ticket.priority', 'user_ticket.attachment', 'user_ticket.status_id', 'user_ticket.created_at', 'ticket_status.status_name', 'site_ticket_department.department_name');
        $ticket->selectRaw('TIMESTAMPDIFF(MINUTE, user_ticket.created_at, close_date) as hours_difference');
        $ticket->omniFilter();

        if (session('company_id') == 1) {
            $department = SiteTicketDepartment::query()->get();
        } else {
            $department = SiteTicketDepartment::query()->where('id', '!=', '1')->get();
        }

        $cust = Customer::query()->select("id", "customer_number", "customer_name", "customer_email")
            ->where("is_active", "1")
            ->orderBy("customer_name")
            ->get();

        return view('page/ticket', [
            'count_ticket_overdue' => $count_ticket_overdue->count(),
            'count_ticket_open' => $count_ticket_open->count(),
            'count_ticket_high' => $count_ticket_high->count(),
            'count_ticket_low' => $count_ticket_low->count(),
            'count_ticket_medium' => $count_ticket_medium->count(),
            'department' => $department,
            'cust' => $cust,
            'data' => $ticket->paginate(30)->withQueryString(),
        ]);

    }


    public function List_close(Request $request)
    {

        $ticket = UserTicket::latest();

        $count_ticket_open = UserTicket::latest();
        $count_ticket_high = UserTicket::latest();
        $count_ticket_low = UserTicket::latest();
        $count_ticket_medium = UserTicket::latest();
        $count_ticket_overdue = UserTicket::latest();

        $count_ticket_open->where('status_id', '!=', 4)->omniFilter();
        $count_ticket_high->where('status_id', 1)->where('Priority', 'High')->omniFilter();
        $count_ticket_low->where('status_id', 1)->where('Priority', 'Low')->omniFilter();
        $count_ticket_medium->where('status_id', 1)->where('Priority', 'Medium')->omniFilter();
        $count_ticket_overdue->where('status_id', '!=', '4')->whereRaw('due_date < CURDATE()')->omniFilter();

        if ($request->department) {
            $ticket->where('department_id', $request->department);
            $count_ticket_open->where('department_id', $request->department);
            $count_ticket_high->where('department_id', $request->department);
            $count_ticket_low->where('department_id', $request->department);
            $count_ticket_medium->where('department_id', $request->department);
            $count_ticket_overdue->where('department_id', $request->department);
        }

        $ticket->where('status_id', '4');

        $ticket->join('ticket_status', 'ticket_status.id', '=', 'user_ticket.status_id');
        $ticket->join('site_ticket_department', 'site_ticket_department.id', '=', 'user_ticket.department_id');

        $ticket->select('user_ticket.id', 'user_ticket.ticket_number', 'due_date', 'close_date', 'user_ticket.customer_name', 'user_ticket.title', 'user_ticket.priority', 'user_ticket.attachment', 'user_ticket.status_id', 'user_ticket.created_at', 'ticket_status.status_name', 'site_ticket_department.department_name');
        $ticket->selectRaw('TIMESTAMPDIFF(MINUTE, user_ticket.created_at, close_date) as hours_difference');

        $ticket->omniFilter();

        if (session('company_id') == 1) {
            $department = SiteTicketDepartment::query()->get();
        } else {
            $department = SiteTicketDepartment::query()->where('id', '!=', '1')->get();
        }

        $cust = Customer::query()->select("id", "customer_number", "customer_name", "customer_email")
            ->where("is_active", "1")
            ->orderBy("customer_name")
            ->get();

        return view('page/ticket', [
            'count_ticket_overdue' => $count_ticket_overdue->count(),
            'count_ticket_open' => $count_ticket_open->count(),
            'count_ticket_high' => $count_ticket_high->count(),
            'count_ticket_low' => $count_ticket_low->count(),
            'count_ticket_medium' => $count_ticket_medium->count(),
            'department' => $department,
            'cust' => $cust,
            'data' => $ticket->paginate(30)->withQueryString(),
        ]);

    }


    public function List_overdue(Request $request)
    {

        $ticket = UserTicket::latest();

        $count_ticket_open = UserTicket::latest();
        $count_ticket_high = UserTicket::latest();
        $count_ticket_low = UserTicket::latest();
        $count_ticket_medium = UserTicket::latest();
        $count_ticket_overdue = UserTicket::latest();


        $count_ticket_open->where('status_id', '!=', 4)->omniFilter();
        $count_ticket_high->where('status_id', 1)->where('Priority', 'High')->omniFilter();
        $count_ticket_low->where('status_id', 1)->where('Priority', 'Low')->omniFilter();
        $count_ticket_medium->where('status_id', 1)->where('Priority', 'Medium')->omniFilter();
        $count_ticket_overdue->where('status_id', '!=', '4')->whereRaw('due_date < CURDATE()')->omniFilter();

        if ($request->department) {
            $ticket->where('department_id', $request->department);
            $count_ticket_open->where('department_id', $request->department);
            $count_ticket_high->where('department_id', $request->department);
            $count_ticket_low->where('department_id', $request->department);
            $count_ticket_medium->where('department_id', $request->department);
            $count_ticket_overdue->where('department_id', $request->department);
        }

        $ticket->where('status_id', '!=', '4');
        $ticket->whereRaw('due_date < CURDATE()');

        // $ticket->where(function ($query) {
        //     $query->whereColumn('close_date', '>', 'due_date')
        //         ->orWhere('close_date', null);
        // });
        // $ticket->whereColumn('close_date', '>', 'due_date')->orWhere('close_date', null);

        $ticket->join('ticket_status', 'ticket_status.id', '=', 'user_ticket.status_id');
        $ticket->join('site_ticket_department', 'site_ticket_department.id', '=', 'user_ticket.department_id');

        $ticket->select('user_ticket.id', 'user_ticket.ticket_number', 'due_date', 'close_date', 'user_ticket.customer_name', 'user_ticket.title', 'user_ticket.priority', 'user_ticket.attachment', 'user_ticket.status_id', 'user_ticket.created_at', 'ticket_status.status_name', 'site_ticket_department.department_name');

        $ticket->omniFilter();

        if (session('company_id') == 1) {
            $department = SiteTicketDepartment::query()->get();
        } else {
            $department = SiteTicketDepartment::query()->where('id', '!=', '1')->get();
        }

        $cust = Customer::query()->select("id", "customer_number", "customer_name", "customer_email")
            ->where("is_active", "1")
            ->orderBy("customer_name")
            ->get();

        return view('page/ticket', [
            'count_ticket_overdue' => $count_ticket_overdue->count(),
            'count_ticket_open' => $count_ticket_open->count(),
            'count_ticket_high' => $count_ticket_high->count(),
            'count_ticket_low' => $count_ticket_low->count(),
            'count_ticket_medium' => $count_ticket_medium->count(),
            'department' => $department,
            'cust' => $cust,
            'data' => $ticket->paginate(30)->withQueryString(),
        ]);

    }

    public function Detail($ticket_id)
    {

        $cek = UserTicket::query()->where('id', (int)$ticket_id)->first();
        if ($cek == null || ($cek->reseller_id != session('reseller_id') && session('company_id') != 1)) {
            return redirect('console/ticket/list/open')->with('failed', 'Not Found');
        }

        $ticket = UserTicket::query()->where('user_ticket.id', (int)$ticket_id)
            ->join('ticket_status', 'ticket_status.id', '=', 'user_ticket.status_id')
            ->join('site_ticket_department', 'site_ticket_department.id', '=', 'user_ticket.department_id')
            ->select('user_ticket.id', 'user_ticket.ticket_number', 'user_ticket.customer_name', 'user_ticket.message', 'user_ticket.title', 'user_ticket.priority', 'user_ticket.attachment', 'user_ticket.status_id', 'user_ticket.created_at', 'ticket_status.status_name', 'site_ticket_department.department_name')
            ->get();

        $ticket_reply = UserTicketReply::latest();
        $ticket_reply->where('ticket_id', (int)$ticket_id);

        return view('page/ticket-detail', [
            'data' => $ticket,
            'reply' => $ticket_reply->paginate(30)->withQueryString(),
        ]);

    }

    public static function count_department_open($id, $status)
    {

        if ($status == 'open') {
            $count = UserTicket::query()->where('department_id', (int)$id)->where('status_id', '!=', 4)->count();
        }

        if ($status == 'close') {
            $count = UserTicket::query()->where('department_id', (int)$id)->where('status_id', 4)->count();
        }

        return $count;
    }


    public function Reply(Request $request)
    {

        $attachment = '';

        $response = 'success';

        if ($request->hasFile('upload')) {

            $iconImageFile = $request->file('upload');
            $iconfilename = $iconImageFile->getClientOriginalName();
            $icontmpFilePath = $iconImageFile->getPathname();
            $iconImageMimeType = $iconImageFile->getClientMimeType();
            $iconimage = new \CURLFile($icontmpFilePath, $iconImageMimeType, $iconfilename);


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('BACKEND_URL') . '/upload/image',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'private'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('BACKEND_TOKEN') . ''
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response);

            $attachment = $response->images;

            $response = $response->status;

            curl_close($curl);
        }

        if ($response) {

            $admin = User::query()->where('id', (int)auth()->user()->id)->first();

            $roleid = UserRole::query()->where('user_id', (int)auth()->user()->id)->first()->role_id;
            $role_name = SiteRole::query()->where('id', (int)$roleid)->first()->role_name;
            $ticket_number = UserTicket::query()->where('id', (int)$request->ticket_id)->first()->ticket_number;
            $ticket_customer_id = UserTicket::query()->where('id', (int)$request->ticket_id)->first()->customer_id;

            $add = UserTicketReply::create([
                'ticket_id' => $request->ticket_id,
                'message' => $request->message,
                'attachment' => $attachment,
                'created_by' => $admin->id,
                'created_by_name' => $admin->first_name . ' ' . $admin->last_name,
                'created_by_position' => $role_name
            ]);

            $Update_status = UserTicket::where('id', $request->ticket_id)->update([
                'status_id' => $request->status_ticket,
            ]);

            // PUSH notification
            $response = Http::withToken(env('BACKEND_TOKEN'))
                ->post(env('BACKEND_URL') . '/notif/create', [
                    "user" => "customer",
                    "template_id" => 4,
                    "id" => $ticket_number,
                    "user_id" => [$ticket_customer_id]
                ]);

            return redirect('/console/ticket/detail/' . $request->ticket_id)->with('success', 'Success, reply ticket to customer');

        } else {

            return redirect('/console/ticket/detail/' . $request->ticket_id)->with('failed', 'Failed, upload attachment');

        }

    }


    public function download_attachments($attachments)
    {

        return response()->streamDownload(function () use ($attachments) {
            $response = Http::withToken(env('BACKEND_TOKEN'))->withHeaders([
                'accept' => 'application/octet-stream',
            ])->get(env('BACKEND_URL') . '/image/private/get/ums/' . $attachments);
            echo $response->body();
        }, $attachments); // replace with actual name

    }


    public function set_close($ticket_id)
    {

        $ticket_customer_id = UserTicket::query()->where('id', (int)$ticket_id)->first()->customer_id;
        $ticket_number = UserTicket::query()->where('id', (int)$ticket_id)->first()->ticket_number;

        $Update_status = UserTicket::where('id', $ticket_id)->update([
            'close_date' => Carbon::now(),
            'status_id' => 4,
        ]);

        // PUSH notification
        $response = Http::withToken(env('BACKEND_TOKEN'))
            ->post(env('BACKEND_URL') . '/notif/create', [
                "user" => "customer",
                "template_id" => 6,
                "id" => $ticket_number,
                "user_id" => [$ticket_customer_id]
            ]);

        return redirect('/console/ticket/detail/' . $ticket_id)->with('success', 'Success, ticket closed');

    }


    public function Create(Request $request)
    {

        $attachment = '';

        $response = '';

        if ($request->hasFile('upload')) {

            $iconImageFile = $request->file('upload');
            $iconfilename = $iconImageFile->getClientOriginalName();
            $icontmpFilePath = $iconImageFile->getPathname();
            $iconImageMimeType = $iconImageFile->getClientMimeType();
            $iconimage = new \CURLFile($icontmpFilePath, $iconImageMimeType, $iconfilename);


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('BACKEND_URL') . '/upload/image',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'private'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('BACKEND_TOKEN') . ''
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response);

            $attachment = $response->images;

            $response = $response->status;

            curl_close($curl);
        }

        if ($response == "success") {

            $tik = UserTicket::query()->orderByDesc('id')->limit(1)->first()->ticket_number;

            $cust_name = Customer::query()
                ->where("id", $request->customer_id)
                ->first()->customer_name;

            $ticket_number = explode("-", $tik);
            $ticket_number = (int)$ticket_number[1] + 1;
            $tn = "TIK-" . sprintf('%05d', $ticket_number);
            $tn = (string)$tn;

            if ($request->priority == "High") {
                $duedate = Carbon::now()->addDays(1);
            } else if ($request->priority == "Medium") {
                $duedate = Carbon::now()->addDays(2);
            } else {
                $duedate = Carbon::now()->addDays(3);
            }


            $add = UserTicket::create([
                'reseller_id' => session('reseller_id'),
                'ticket_number' => $tn,
                'department_id' => 2,
                'title' => $request->title,
                'message' => $request->message,
                'customer_id' => $request->customer_id,
                'customer_name' => $cust_name,
                'priority' => $request->priority,
                'due_date' => $duedate,
                'status_id' => '1',
                'attachment' => $attachment,
                'created_by' => auth()->user()->id,
            ]);

            // Set Notification
            $params_notif = [
                "subject" => "Tiket Baru Dari Pelanggan",
                "message" => "Pelanggan baru saja membuat ticket dengan number " . $tn,
                "group_id" => "2"
            ];
            
            // notif to Network Engineer
            $notif = app(AdminController::class)->Create_notification('2', $params_notif);

            return redirect()->back()->with('success', 'Create ticket successful !');

        } else {

            return redirect()->back()->with('failed', 'Failed, upload attachment !');

        }

    }





}
