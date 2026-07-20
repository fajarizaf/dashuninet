<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\Reseller;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\SiteRouter;

class ResellerController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function list(Request $request)
    {

        $reseller = Reseller::latest();

        $reseller->select('reseller.id', 'bandwidth', 'reseller_name', 'reseller_phone', 'reseller_email', 'reseller.created_at');
        $reseller->orderByDesc('reseller.created_at');

        return view('page/reseller', [
            'data' => $reseller->paginate(30)->withQueryString(),
        ]);

    }

    public function Create(Request $request)
    {
        // dd($request);
        $reseller_create = Reseller::create([
            'bandwidth' => $request->bandwidth,
            'reseller_name' => $request->reseller_name,
            'reseller_email' => $request->owner_email,
            'reseller_phone' => $request->reseller_phone,
            'reseller_address' => $request->reseller_address,
            'status' => $request->status,
        ]);

        $user_create = User::create([
            'reseller_id' => $reseller_create->id,
            'first_name' => $request->owner_name,
            'user_email' => $request->owner_email,
            'phone' => $request->reseller_phone,
            'address' => $request->reseller_address,
            'password' => bcrypt($request->password),
            'is_verified' => 1,
            'is_active' => 1,
        ]);

        $company_create = UserCompany::create([
            'user_id' => $user_create->id,
            'company_id' => 2,
        ]);

        $role_create = UserRole::create([
            'user_id' => $user_create->id,
            'role_id' => 3,
        ]);

        return redirect()->back()->with('success', 'Success, create new reseller');

    }

    public function Update(Request $request)
    {
        $Update = Reseller::where('id', $request->reseller_id)->update([
            'bandwidth' => $request->bandwidth,
            'reseller_name' => $request->reseller_name,
            'reseller_phone' => $request->reseller_phone,
            'reseller_address' => $request->reseller_address,
            'status' => $request->status,
        ]);

        $userData = User::query()
        ->select('id')
        ->where('reseller_id', $request->reseller_id)
        ->orderBy('id')
        ->first();

        $UserUpdate = User::where('id', $userData->id)->update([
            'first_name' => $request->owner_name,
            'phone' => $request->reseller_phone,
            'address' => $request->reseller_address,
        ]);

        if($request->password) {
            $UserUpdate = User::where('id',$userData->id)->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect('/console/reseller')->with('success', 'Success, Update reseller');
    }

    public function Detail(Request $request)
    {
        $get = Reseller::query()
        ->select('reseller.id', 'bandwidth', 'reseller_name', 'reseller_phone', 'reseller_address', 'reseller_email', 'reseller.status', 'reseller.created_at', DB::raw('(select first_name from user left join user_role ON user_role.user_id = user.id where reseller_id = reseller.id  order by user.id asc limit 1) as first_name')  )
        // ->leftjoin('user', 'user.id', '=', 'reseller.user_id')
        ->where('reseller.id', $request->reseller_id)
        ->first();
        return $get;
    }

    public function Login(Request $request)
    {
        $userData = User::query()
        ->select('user.id', 'user_email')
        ->leftJoin('user_role', 'user.id', '=', 'user_role.user_id')
        ->where('user_role.role_id', '3') //Admin
        ->where('reseller_id', $request->reseller_id)
        ->orderBy('user.id')
        ->first();
        
        // if (Auth::attempt(['user_email' => $userData->user_email, 'is_active' => 1])) {
        if ($userData) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
    
            if (Auth::loginUsingId($userData->id)) {
                $request->session()->regenerate();
    
                $reseller_id = $request->reseller_id;
        
                $request->session()->put('role_id', 3); //Admin
                $request->session()->put('company_id', 2); //Uninet
                $request->session()->put('reseller_id', $reseller_id);
                $request->session()->put('from', 'limputra');
        
                return true;
            }
        } else {
            return false;
        }
            
    }

    public function Backtolimputra(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if (Auth::loginUsingId(3)) {
            $request->session()->regenerate();

            $request->session()->put('role_id', 3); //Admin
            $request->session()->put('company_id', 1); //Limputra
            // $request->session()->put('reseller_id', $reseller_id);
            $request->session()->put('from', '');
    
            return redirect('/console/salesorder')->with('success', 'Success, Login as Admin Limputra');
        }
    }


}
