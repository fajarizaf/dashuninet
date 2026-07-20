<?php
 
namespace App\Http\Controllers;

use App\Models\Pipeline;
use App\Models\SiteProductGroup;
use App\Models\UserRole;
use App\Models\SiteProject;
use App\Models\SiteEmployee;
use Illuminate\Http\Request;
 
use App\Http\Controllers\Controller;

class PipelineController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function List(Request $request) {
        
         $pipeline = Pipeline::latest();
 
         if ($request->pic_name) {
             $pipeline->where('pipeline.pic_name', $request->pic_name);
         }
 
        //  if ($request->sales_pic) {
        //      $pipeline->where('position_name', $request->sales_pic);
        //  }

         if ($request->year) {
            $pipeline->whereYear('pipeline.created_at', $request->year);
         }

         if ($request->month) {
            $pipeline->whereMonth('pipeline.created_at', $request->month);
         }

         if ($request->sales_pic) {
            $pipeline->where('pipeline.created_by', $request->sales_pic);
         }

         $pipeline->select('pipeline.id', 'pipeline.pic_name', 'pipeline.telp', 'pipeline.email', 'site_product.product_name', 'site_product.product_plan', 'pipeline.created_at','user.first_name','user.last_name','pipeline.created_at');
         $pipeline->leftjoin('site_product', 'site_product.id', '=', 'pipeline.product_id');
         $pipeline->leftjoin('user', 'user.id', '=', 'pipeline.created_by');
         $pipeline->where('pipeline.is_hidden', (int) 0);

         $pipeline->omniFilter();

         $product_group = SiteProductGroup::query()->where('is_hidden', (int) 0)->get();
         $sales_pic = UserRole::query()->select('user.id', 'user.first_name', 'user.last_name')->where('user_role.role_id', (int) 1)->where('user.is_active', (int) 1)->join('user', 'user.id', '=', 'user_role.user_id')->get();
         $site_project = SiteProject::query()->where('status', '=', 'active')->get();
         $site_employee = SiteEmployee::query()->where('status', '=', 'active')->orderBy('name')->get();
        
        
         return view('page/pipeline', [
            'product_group' => $product_group,
            'sales_pic' => $sales_pic,
            'site_project' => $site_project,
            'site_employee' => $site_employee,
            'data' => $pipeline->paginate(30)->withQueryString(),
         ]);
 
    }


    public function Create_pipeline(Request $request) {

        $pipline_create = Pipeline::create([
            'reseller_id' => session('reseller_id'),
            'pic_name' => $request->pic_name,
            // 'position_name' => $request->position_name,
            'place_of_bussines' => $request->place_of_bussines,
            'area' => $request->area,
            'exist_product' => $request->exist_product,
            'price_product' => $request->price_product,
            'bandwidth_product' => $request->bandwidth_product,
            'keterangan' => $request->keterangan,
            'telp' => $request->telp,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
            'modified_by' => auth()->user()->id,
            'is_hidden' => 0,
        ]);

        return redirect('/console/pipeline')->with('success', 'Success, Create new Pipeline');

    }


    public function Update_pipeline(Request $request)
    {

        $Update = Pipeline::where('id', $request->pipeline_id)->update([
            'pic_name' => $request->pic_name,
            // 'position_name' => $request->position_name,
            'place_of_bussines' => $request->place_of_bussines,
            'area' => $request->area,
            'exist_product' => $request->exist_product,
            'price_product' => $request->price_product,
            'bandwidth_product' => $request->bandwidth_product,
            'keterangan' => $request->keterangan,
            'telp' => $request->telp,
            'email' => $request->email,
            'nama_jalan' => $request->nama_jalan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'link_maps' => $request->link_maps,
            'jenis_bangunan' => $request->jenis_bangunan,
            'modified_by' => auth()->user()->id,
        ]);

        if ($Update) {
            return redirect('/console/pipeline')->with('success', 'Success, Update Pipeline');
        } else {
            return redirect('/console/pipeline')->with('failed', 'Failed, Update Pipeline');
        }
        

    }

    public function Detail(Request $request)
    {
        $get = Pipeline::query()->select('area', 'bandwidth_product', 'pipeline.id', 'pic_name', 'place_of_bussines', 'exist_product', 'price_product', 'keterangan', 'telp', 'email', 'pipeline.created_at', 'pipeline_type', 'pipeline.product_id', 'nama_jalan', 'rt', 'rw', 'kelurahan', 'kecamatan', 'kabupaten', 'link_maps', 'jenis_bangunan', 'product_name', 'product_plan', 'price','user.first_name','user.last_name','pipeline.created_at')
        ->leftJoin('site_product', 'site_product.id', '=', 'pipeline.product_id')
        ->leftJoin('site_product_price', 'site_product_price.product_id', '=', 'site_product.id')
        ->leftjoin('user', 'user.id', '=', 'pipeline.created_by')
        ->where('pipeline.id', $request->pipeline_id)->first();
        return $get;
    }



    public function Rejected_pipeline($pipeline_id)
    {

        $Update = Pipeline::where('id', $pipeline_id)->update([
            'is_hidden' => 1,
            'keterangan' => 'rejected by admin'
        ]);

        return redirect('/console/pipeline')->with('success', 'Success, Rejected Pipeline');

    }


    


}
