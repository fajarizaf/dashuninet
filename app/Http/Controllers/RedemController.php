<?php
 
namespace App\Http\Controllers;

use App\Models\CustomerCreditPoint;
use App\Models\CustomerRedem;
use App\Models\LogActivity;
use App\Models\SiteExpedition;
use App\Models\SiteReward;
use App\Models\Customer;
use Illuminate\Http\Request;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class RedemController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

        public function List_queue(Request $request) {
     
            $redem = CustomerRedem::latest();

            $count_redem_pending = CustomerRedem::query()->where('redem_status', 1036)->count();
            $count_redem_process = CustomerRedem::query()->where('redem_status', 1037)->count();
            $count_redem_shipment = CustomerRedem::query()->where('redem_status', 1049)->count();

            $count_redem = CustomerRedem::query()->whereIn('redem_status', array(1036,1037,1049))->count();

    
            if ($request->redem_status) {
                $redem->where('redem_status', $request->redem_status);
            }

            $redem->where('customer_redem.redem_status','!=', 1035);

            $redem->join('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id');
            $redem->join('customer', 'customer.id', '=', 'customer_redem.customer_id');
            $redem->join('site_status', 'site_status.id', '=', 'customer_redem.redem_status');

            
            if ($request->customer_request) {
                $redem->where('customer.customer_name', 'like','%'.$request->customer_request.'%');
            }

            $redem->select('customer_redem.id','customer.customer_name','site_reward.reward_name','site_status.status_name','customer_redem.created_at','site_reward.reward_point','site_reward.reward_cover');
        
            return view('page/redem', [
            'count_redem' => $count_redem,
            'count_redem_pending' => $count_redem_pending,
            'count_redem_process' => $count_redem_process,
            'count_redem_shipment' => $count_redem_shipment,
            'data' => $redem->paginate(30)->withQueryString(),
            ]);

        }


        public function List_complete(Request $request) {
     
            $redem = CustomerRedem::latest();

            $count_redem_complete = CustomerRedem::query()->where('redem_status', 1035)->count();

            if ($request->redem_status) {
                $redem->where('redem_status', $request->redem_status);
            }

            $redem->where('customer_redem.redem_status','=', 1035);

            $redem->join('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id');
            $redem->join('customer', 'customer.id', '=', 'customer_redem.customer_id');
            $redem->join('site_status', 'site_status.id', '=', 'customer_redem.redem_status');

            if ($request->customer_request) {
                $redem->where('customer.customer_name', 'like','%'.$request->customer_request.'%');
            }

            $redem->select('customer_redem.id','customer.customer_name','site_reward.reward_name','site_status.status_name','customer_redem.created_at','site_reward.reward_point','site_reward.reward_cover');
        
            return view('page/redem-complete', [
            'count_redem_complete' => $count_redem_complete,
            'data' => $redem->paginate(30)->withQueryString(),
            ]);

        }


        public function Detail($redem_id) {
     
            $detail = CustomerRedem::query()
            ->join('site_reward', 'site_reward.id', '=', 'customer_redem.reward_id')
            ->join('customer', 'customer.id', '=', 'customer_redem.customer_id')
            ->join('site_status', 'site_status.id', '=', 'customer_redem.redem_status')
            ->where('customer_redem.id', $redem_id)
            ->select('customer_redem.id','customer.customer_name','customer_redem.created_at','customer_redem.shipment_address','customer_redem.shipment_awb','site_reward.reward_name','site_reward.reward_point','site_reward.reward_description','site_status.id as status_id','site_status.status_name','site_reward.reward_cover','customer_redem.expedition_id','customer_redem.redem_note')
            ->first();

            $admin_activity = LogActivity::query()
            ->where('module', 'redeem')
            ->where('module_id', (int) $redem_id)
            ->orderByDesc('created_at')
            ->get();

            $redem_transaction = CustomerCreditPoint::query()->where('redem_id', (int) $redem_id)->get();

            $expedition = SiteExpedition::query()->where('expedition_status', (int) 1001)->get();

            return view('page/redem-detail', [
                'detail' => $detail,
                'redem_transaction' => $redem_transaction,
                'admin_activity' => $admin_activity,
                'expedition'=> $expedition
            ]);

        }


        public function Update(Request $request) {

            $redem_id       = $request->redem_id;
            $action_type    = $request->action_type;
            $redem_notes    = $request->redem_notes;
            $no_resi        = $request->no_resi;
            $expedition_id  = $request->expedition_id;
            
            // shipments
            if($action_type == '1049') {
                if($no_resi == '') {
                    return redirect('/console/redem/detail/' . $redem_id)->with('failed', 'Message response : Input field shipment awbis mandatory');
                }

                if($expedition_id == '') {
                    return redirect('/console/redem/detail/' . $redem_id)->with('failed', 'Message response : Input field expedition name is mandatory');
                }
            }

            // reject
            if($action_type == '1050') {
                if($redem_notes == '') {
                    return redirect('/console/redem/detail/' . $redem_id)->with('failed', 'Message response : Input field redem notes is mandatory');
                }
            }
    
            // PUSH notification
            $response = Http::withToken(env('BACKEND_TOKEN'))
            ->put(env('BACKEND_URL').'/redeem/update/'.$redem_id, [
                "action_id" => (int)$action_type,
                "shipment_awb" => $no_resi,
                "expedition_id" => $expedition_id,
                'redem_note' => $redem_notes,
            ]);
            
            $response = $response->object();

            if(!empty($response->status)) {

                if($response->status =='Success') {
                    return redirect('/console/redem/detail/' . $redem_id)->with('success', 'Message response : '.$response->message);
                } else {
                    return redirect('/console/redem/detail/' . $redem_id)->with('failed', 'Message response : '.$response->message);
                } 

            } else {
                return redirect('/console/redem/detail/' . $redem_id)->with('failed', 'Message response : Terdapat masalah pada endpoint sistem, hubungan developer');
            }
            
        }


        public static function get_expedition_name($expedition_id)
        {

            $name = SiteExpedition::query()->where('id', $expedition_id)->first()->expedition_name;
            echo $name;

        }


}