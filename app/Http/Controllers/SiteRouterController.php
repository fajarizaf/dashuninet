<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\SiteRouter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class SiteRouterController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function list(Request $request)
    {
        $router = SiteRouter::latest();

        $router->select('id', 'label_name', 'ipaddress', 'username', 'password', 'status', 'created_at');
        $router->where('status', '!=', 'deleted');
        $router->orderByDesc('created_at');

        return view('page/router', [
            'data' => $router->paginate(30)->withQueryString(),
        ]);
    }

    public function Create(Request $request)
    {
        $router_create = SiteRouter::create([
            'label_name' => $request->label_name,
            'ipaddress' => $request->ipaddress,
            'username' => $request->username,
            'password' => $request->password,
            'status' => $request->status,
        ]);

        return redirect('/console/router')->with('success', 'Success, create new router');
    }

    public function Detail(Request $request)
    {
        $get = SiteRouter::query()->where('id', $request->router_id)->first();
        return $get;
    }

    public function Delete(Request $request)
    {
        $Update = SiteRouter::where('id', $request->router_id)->update([
            'status' => 'deleted',
        ]);

        return redirect('/console/router')->with('success', 'Success, deleted router');
    }

    public function Update(Request $request)
    {
        $Update = SiteRouter::where('id', $request->router_id)->update([
            'label_name' => $request->label_name,
            'ipaddress' => $request->ipaddress,
            'username' => $request->username,
            'password' => $request->password,
            'status' => $request->status,
        ]);

        return redirect('/console/router')->with('success', 'Success, Update router');
    }


    public function set_active(Request $request) {
        $Update = SiteRouter::where('id',$request->router_id)->update([
            'status' => 'active',
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'router',
            'module_id' => $request->router_id,
            'log_label' => 'Set Active Router',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_active router, with Router id :'.$request->router_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }

    public function set_deactive(Request $request) {
        $Update = SiteRouter::where('id',$request->router_id)->update([
            'status' => 'deactive',
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'router',
            'module_id' => $request->router_id,
            'log_label' => 'Set Deactive Router',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_deactive router, with Router id :'.$request->router_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }


}
