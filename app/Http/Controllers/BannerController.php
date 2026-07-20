<?php

namespace App\Http\Controllers;

use DB;
use App\Models\SiteBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class BannerController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function list(Request $request)
    {

        $banner = SiteBanner::latest();

        $banner->select('id', 'banner_name', 'created_at', 'banner_link', 'category', DB::raw('(CASE WHEN is_hidden = 1 THEN "Yes" ELSE "No" END) AS is_hidden'));
        $banner->orderByDesc('created_at');

        return view('page/banner', [
            'data' => $banner->paginate(30)->withQueryString(),
        ]);

    }

    public function Create(Request $request)
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

            $banner_create = SiteBanner::create([
                'banner_name' => $request->banner_name,
                'is_hidden' => $request->is_hidden,
                'category' => $request->category,
                'banner_link' => $attachment,
            ]);

            return redirect('/console/banner')->with('success', 'Success, create new banner');

        } else {

            return redirect('/console/banner')->with('failed', 'Failed, upload attachment');

        }

    }


    public function Detail(Request $request)
    {
        $get = SiteBanner::query()->where('id', $request->banner_id)->first();
        return $get;
    }

    public function Update(Request $request)
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

            if($response == "success") {
                $Update = SiteBanner::where('id', $request->banner_id)->update([
                    'banner_name' => $request->banner_name,
                    'is_hidden' => $request->is_hidden,
                    'category' => $request->category,
                    'banner_link' => $attachment,
                ]);    

                return redirect()->back()->with('success', 'Success, Update banner');
            }else{
                return redirect()->back()->with('failed', 'Failed, upload attachment');
            }
            
        }else{
            $Update = SiteBanner::where('id', $request->banner_id)->update([
                'banner_name' => $request->banner_name,
                'is_hidden' => $request->is_hidden,
                'category' => $request->category,
            ]);
            return redirect()->back()->with('success', 'Success, Update banner');
        }

    }


}
