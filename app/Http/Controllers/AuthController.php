<?php
 
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

     public function index(Request $request)
     {
        return redirect('/login');
     }


     public function login(Request $request)
     {

        if(!Auth::check()) {
            return view('page/login');
        } else {
            
            return redirect('/console/salesorder');
        }
        
     }

     public function auth_login(Request $request)
     {
         $credentials = $request->validate([
             'user_email' => 'required',
             'password' => 'required'
         ]);
 
        //  if (Auth::attempt(['user_email' => $user_email, 'password' => $password, 'is_active' => 1])) {
        //     // Authentication was successful...
        // }
         if(Auth::attempt($credentials)) {
             

             $is_active = User::where('user_email', $request->user_email)->first()->is_active;
             
             if($is_active == 1) {

                $request->session()->regenerate();

                $user_id = User::where('user_email', $request->user_email)->first()->id;
                $reseller_id = User::where('user_email', $request->user_email)->first()->reseller_id;
                $company_id = UserCompany::where('user_id', (int)$user_id)->first()->company_id;
             
                $role_id = UserRole::where('user_id',(int)$user_id)->first()->role_id;
                
                $request->session()->put('role_id', $role_id);
                $request->session()->put('company_id', $company_id);
                $request->session()->put('reseller_id', $reseller_id);

                return redirect()->intended('/console/salesorder');

             } else {

                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return redirect('/login')->with('loginError', 'Account is deactive');
                
             }

             
         }
 
         return redirect('/login')->with('loginError', 'Login Failed');
     }


     public function auth_logout(Request $request)
     {
         Auth::logout();
         request()->session()->invalidate();
         request()->session()->regenerateToken();
         return redirect()->intended('/login');
     }


}
