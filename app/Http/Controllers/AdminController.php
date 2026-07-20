<?php
 
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserNotif;
use App\Models\UserRole;
use App\Models\SiteRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


     public function List(Request $request)
     {

        $user = User::latest();

        $user->join('user_role', 'user_role.user_id', '=', 'user.id');
        $user->join('site_role', 'site_role.id', '=', 'user_role.role_id');

        $user->select('phone', 'user.id','user.is_active','user.created_at','user.first_name', 'user.last_name', 'user.user_email', 'site_role.role_name','site_role.role_type');
        $user->orderByDesc('user.created_at');

        if ($request->user_name) {
            // $user->where('user.first_name', 'LIKE', "%$request->user_name%" );
            $param = $request->user_name;
            $user->where(function ($query) use ($param) {
                $query->where('user.first_name', 'LIKE', "%$param%")
                      ->orWhere('user.last_name', 'LIKE', "%$param%");
            });
        }
        if ($request->user_status != '') {
            $user->where('user.is_active', $request->user_status);
        }
        if ($request->user_role != '') {
            $user->where('user_role.role_id', $request->user_role);
        }

        $user->omniFilter();

        if (session('company_id') == 1) {
            $role = SiteRole::query()->where('status_id', '1001')->get();
        } else {
            $role = SiteRole::query()->where('status_id', '1001')->where('id', '!=', '4')->get();
        }
        

        return view('page/admin', [
            'role' => $role,
            'data' => $user->paginate(30)->withQueryString(),
        ]);
        
     }


     public function Detail(Request $request)
    {
        $get = User::query()->where('user.id', $request->user_id)
            ->join('user_role', 'user_role.user_id', '=', 'user.id')
            ->join('site_role', 'site_role.id', '=', 'user_role.role_id')
            ->first();
        return $get;
    }


    public function set_deactive(Request $request) {

        $Update = User::where('id',$request->user_id)->update([
            'is_active' => 0,
        ]);
        return $Update;

    }


    public function set_active(Request $request) {

        $Update = User::where('id',$request->user_id)->update([
            'is_active' => 1,
        ]);
        return $Update;

    }



    public function Update(Request $request) {


        $Update = User::where('id',$request->user_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);

        if($request->user_password) {
            $Update = User::where('id',$request->user_id)->update([
                'password' => bcrypt($request->user_password),
            ]);
        }

        if($request->user_role) {
            $Update = UserRole::where('user_id',$request->user_id)->update([
                'role_id' => $request->user_role,
                // 'company_id' => $request->session()->get('company_id'),
            ]);
        }

        return redirect('/console/admin')->with('success','Success, Update credential admin');

    }


     public function Create(Request $request)
    {

        $ADMIN_EXIST = User::query()->where('user_email', $request->user_email)->count();

        if ($ADMIN_EXIST == 0) {

            $USER = User::create([
                'reseller_id' => session('reseller_id'),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'user_email' => $request->user_email,
                'password' => bcrypt($request->user_password),
                'phone' => $request->phone,
                'is_active' => 1,
                'is_verified' => 1,
                'created_by' => auth()->user()->id,
                'modified_by' => auth()->user()->id,
            ]);

            $USER_ROLE = UserRole::create([
                'user_id' => $USER->id,
                'role_id' => $request->user_role,
                // 'company_id' => $request->session()->get('company_id')
            ]);

            $USER_COMPANY = UserCompany::create([
                'user_id' => $USER->id,
                'company_id' => $request->session()->get('company_id')
            ]);

            return redirect('/console/admin')->with('success','Success create new Admin');

        } else {

            return redirect('/console/admin')->with('failed','Failed, this email has been registered');

        }

    }

    public static function Get_name($id) {
        $user = User::query()->where('id', (int) $id)->first();
        if(!empty($user->first_name)) {
            $name = $user->first_name.' '.$user->last_name;
        } else {
            $name = '';
        }
        
        return $name;
    }


    public function Create_notification($role_id,$params) {

        $get_userid_list = UserRole::query()->where('role_id', $role_id)->get();
        foreach($get_userid_list as $user){
            
            $NOTIF = UserNotif::create([
                'subject' => $params['subject'],
                'message' => $params['message'],
                'readable' => 0,
                'user' => 'admin',
                'user_id' => $user->user_id,
                'group_id' => $params['group_id'],
            ]);
        }
        return $NOTIF;

    }


    public static function List_notifications() {
        $notif = UserNotif::query()->where('user_id', (int) auth()->user()->id)->orderBy('createdAt', 'desc')->limit(10)->get();
        return $notif;
    }

    public function Read_notif() {

        $read = UserNotif::where('user_id', auth()->user()->id)->update([
            'readable' => 1
        ]);
        return $read;
        
    }

    public static function Count_notifications() {
        $count = UserNotif::query()->where('user_id', (int) auth()->user()->id)->where('readable', 0)->count();
        return $count;
    }


}
