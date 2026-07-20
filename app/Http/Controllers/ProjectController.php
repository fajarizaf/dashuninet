<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use App\Models\SiteProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\SiteRouter;

class ProjectController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function list(Request $request)
    {

        $project = SiteProject::latest();

        $project->select('label_name', 'site_project.id', 'project_name', 'project_goals', 'project_address', 'project_start', 'project_end', 'site_project.status', 'site_project.created_at');
        $project->leftjoin('site_router', 'site_router.id', '=', 'site_project.router_id');
        $project->where('site_project.status', '!=', 'deleted');
        $project->orderByDesc('site_project.created_at');

        $site_router = SiteRouter::query()->where('status', '!=', 'deleted')->get();

        return view('page/project', [
            'data' => $project->paginate(30)->withQueryString(),
            'site_router' => $site_router
        ]);

    }

    public function Create(Request $request)
    {

        $project_create = SiteProject::create([
            'router_id' => $request->router_id,
            'project_name' => $request->project_name,
            'project_goals' => $request->project_goals,
            'project_address' => $request->project_address,
            'project_description' => $request->project_description,
            'project_start' => $request->project_start,
            'project_end' => $request->project_end,
            'status' => $request->status,
            // 'created_by' => auth()->user()->id,
            // 'modified_by' => auth()->user()->id
        ]);

        return redirect('/console/project')->with('success', 'Success, create new project');

    }

    public function Detail(Request $request)
    {
        $get = SiteProject::query()
        ->select('router_id', 'site_project.id', 'project_name', 'project_goals', 'project_address', 'project_start', 'project_end', 'site_project.status', 'site_project.created_at')
        ->leftjoin('site_router', 'site_router.id', '=', 'site_project.router_id')
        ->where('site_project.id', $request->project_id)
        ->first();
        return $get;
    }

    public function Delete(Request $request)
    {
        $Update = SiteProject::where('id', $request->project_id)->update([
            'status' => 'deleted',
        ]);

        return redirect('/console/project')->with('success', 'Success, deleted project');
    }

    public function Update(Request $request)
    {
        $Update = SiteProject::where('id', $request->project_id)->update([
            'router_id' => $request->router_id,
            'project_name' => $request->project_name,
            'project_goals' => $request->project_goals,
            'project_address' => $request->project_address,
            'project_description' => $request->project_description,
            'project_start' => $request->project_start,
            'project_end' => $request->project_end,
            'status' => $request->status,
            // 'modified_by' => auth()->user()->id,
        ]);

        return redirect('/console/project')->with('success', 'Success, Update project');
    }


    public function set_active(Request $request) {
        $Update = SiteProject::where('id',$request->area_id)->update([
            'status' => 'active',
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'project area',
            'module_id' => $request->area_id,
            'log_label' => 'Set Active Project Area',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_active project area, with Area id :'.$request->area_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }

    public function set_deactive(Request $request) {
        $Update = SiteProject::where('id',$request->area_id)->update([
            'status' => 'deactive',
        ]);

        $LOG_ACTIVITY = LogActivity::create([
            'module' => 'project area',
            'module_id' => $request->area_id,
            'log_label' => 'Set Deactive Project Area',
            'log_entry' => auth()->user()->first_name.' '.auth()->user()->last_name.' has been set_deactive project area, with Area id :'.$request->area_id,
            'log_user_name' => auth()->user()->first_name.' '.auth()->user()->last_name,
            'log_user_id' => auth()->user()->id,
            'log_user_ip' => request()->ip(),
        ]);

        return $Update;
    }


}
