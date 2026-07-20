<?php

namespace App\Http\Controllers;

use App\Models\Documentation_cat;
use DB;
use App\Models\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class DocController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


     public function view_list(Request $request)
     {
 
         $categori = Documentation_cat::query()->get();
         
 
         return view('page/list-documentations', [
             'categori' => $categori,
         ]);
 
     }

     public function view_list_detail($doc_id)
     {
 
        $documentation = Documentation::query()->where('id', $doc_id)->get();
        $categori_id = Documentation::query()->where('id', $doc_id)->first()->cat;
        $list_documentation = Documentation::query()->where('cat', $categori_id)->get();
        $categori_name = Documentation_cat::query()->where('id', $categori_id)->first()->name_doc_cat;
 
         return view('page/detail-documentations', [
             'documentation' => $documentation,
             'categori' => $categori_name,
             'list_documentation' => $list_documentation
         ]);
 
     }

     public static function get_list_doc($categori)
     {
 
        $documentation = Documentation::query()->where('cat', $categori)->where('app', 'dashboard portal')->get();

        if($documentation->isNotEmpty()) {
            echo "<ul>";
            foreach ($documentation as $doc) {

                echo "<li><a href='/console/panduan/detail/".$doc->id."'>".$doc->title."</a></li>";

            }
            echo "</ul>";

        } else {

            echo "<ul>";
            echo "<li><a href='#'>No Documentation Found</a></li>";
            echo "</ul>";

        }
 
     }

     public static function get_name_cat($id)
     {
 
        $name = Documentation_cat::query()->where('id', $id)->first()->name_doc_cat;

        echo $name;
 
     }


    public function list(Request $request)
    {

        $documentation = Documentation::latest();
        // $documentation->where('status', '!=', 'deleted');
        $documentation->orderByDesc('created_at');

        if ($request->title) {
            $documentation->where('title', 'like' , '%'.$request->title.'%');
        }

        if ($request->app) {
            $documentation->where('app', $request->app);
        }

        if ($request->type) {
            $documentation->where('type', $request->type);
        }

        if ($request->is_visible) {
            $documentation->where('is_visible', $request->is_visible);
        }

        $categori = Documentation_cat::query()->get();

        return view('page/documentations', [
            'data' => $documentation->paginate(30)->withQueryString(),
            'categori' => $categori
        ]);

    }

    public function Create(Request $request)
    {

        $documentation_create = Documentation::create([
            'title' => $request->title,
            'slug' => $request->title,
            'type' => $request->type,
            'app' => $request->app,
            'cat' => $request->categori,
            'is_visible' => $request->is_visible,
            'content' => $request->content,
            // 'created_by' => auth()->user()->id,
            // 'modified_by' => auth()->user()->id
        ]);

        return redirect('/console/documentation')->with('success', 'Success, create new documentation');

    }
    

    public function Img(Request $request)
    {
        if ($request->hasFile('file')) {

            $iconImageFile = $request->file('file');
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
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'public'),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . env('BACKEND_TOKEN') . ''
                ),
            ));

            $response = curl_exec($curl);

            $response = json_decode($response);

            $attachment = $response->images;

            $response = $response->status;

            curl_close($curl);

            return json_encode(['location' => env('BACKEND_URL').'/image/get/ums/' . $attachment]);
        }else{
            return json_encode('gagal upload');
        }
    }

    public function Create2(Request $request)
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
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'public'),
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

            $documentation_create = Documentation::create([
                'documentation_name' => $request->documentation_name,
                'documentation_point' => $request->documentation_point,
                'documentation_description' => $request->keterangan,
                'status' => $request->status,
                'documentation_cover' => $attachment,
                // 'created_by' => auth()->user()->id,
                // 'modified_by' => auth()->user()->id
            ]);

            return redirect('/console/documentation')->with('success', 'Success, create new documentation');

        } else {

            return redirect('/console/documentation')->with('failed', 'Failed, upload attachment');

        }

    }


    public function Detail(Request $request)
    {
        $get = Documentation::query()->where('id', $request->documentation_id)->first();
        return $get;
    }

    public function Delete(Request $request)
    {
        $Update = Documentation::where('id', $request->documentation_id)->update([
            'status' => 'deleted',
        ]);

        return redirect('/console/documentation')->with('success', 'Success, deleted documentation');
    }

    public function Update(Request $request)
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
                CURLOPT_POSTFIELDS => array('upload' => $iconimage, 'type' => 'ums', 'privacy' => 'public'),
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

            $Update = Documentation::where('id', $request->documentation_id)->update([
                'title' => $request->title,
                'app' => $request->app,
                'slug' => $request->title,
                'type' => $request->type,
                'cat' => $request->categori,
                'is_visible' => $request->is_visible,
                'content' => $request->content,
            ]);

            return redirect('/console/documentation')->with('success', 'Success, Update documentation');

        } else {

            return redirect('/console/documentation')->with('failed', 'Failed, upload attachment');

        }



    }


}
