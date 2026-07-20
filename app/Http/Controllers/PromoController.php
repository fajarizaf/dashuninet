<?php
 
namespace App\Http\Controllers;

use App\Models\CustomerCreditPoint;
use App\Models\CustomerRedem;
use App\Models\LogActivity;
use App\Models\Promo;
use App\Models\SiteExpedition;
use App\Models\SiteReward;
use App\Models\Customer;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Str;

class PromoController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

        public function List(Request $request) {
     
            $promo = Promo::latest();

            
            return view('page/promo', [
            'data' => $promo->paginate(10)->withQueryString(),
            ]);

        }

        public function create(Request $request) {
            
            $promo = Promo::create([
                'promotion_code' => $request->promo_code,
                'promotion_label' => $request->promo_label,
                'promotion_desc' => $request->promo_description,
                'type' => $request->promo_type,
                'subscription_month' => $request->subscription_month,
                'value' => $request->value,
                'period_free' => $request->period_free,
                'setup_free' => $request->free_setup,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'max_user' => $request->max_user,
                'is_active' => $request->is_active,
            ]);

            return redirect('/console/promo')->with('success', 'Success, create new promo configuration');

        }

        public function update(Request $request) {
            
            $promo = Promo::where('id', $request->promo_id)->update([
                'promotion_code' => $request->promo_code,
                'promotion_label' => $request->promo_label,
                'promotion_desc' => $request->promo_description,
                'type' => $request->promo_type,
                'subscription_month' => $request->subscription_month,
                'value' => $request->value,
                'period_free' => $request->period_free,
                'setup_free' => $request->free_setup,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'max_user' => $request->max_user,
                'is_active' => $request->is_active,
            ]);

            return redirect('/console/promo')->with('success', 'Success, update promo configuration');

        }

        public function Get(Request $request) {
            
            $get = Promo::query()->where('id', $request->id)->first();
            return $get;

        }

        public function generate_promo_code() {
            $code = Str::random(9);
            return $code;
        }



}