<?php

namespace App\Http\Controllers;

use App\Models\SiteReward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class RewardController extends Controller
{

    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */


    public function list(Request $request)
    {

        $reward = SiteReward::latest();

        $reward->select('id', 'reward_name', 'created_at', 'reward_point', 'reward_description', 'reward_cover', 'status');
        $reward->where('status', '!=', 'deleted');
        $reward->orderByDesc('created_at');

        return view('page/reward', [
            'data' => $reward->paginate(30)->withQueryString(),
        ]);

    }

    public function Create2(Request $request)
    {

        $reward_create = SiteReward::create([
            'reward_name' => $request->reward_name,
            'reward_point' => $request->reward_point,
            'reward_description' => $request->keterangan,
            'status' => $request->status,
            // 'created_by' => auth()->user()->id,
            // 'modified_by' => auth()->user()->id
        ]);

        return redirect('/console/reward')->with('success', 'Success, create new reward');

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

            $reward_create = SiteReward::create([
                'reward_name' => $request->reward_name,
                'reward_point' => $request->reward_point,
                'reward_description' => $request->keterangan,
                'status' => $request->status,
                'reward_cover' => $attachment,
                // 'created_by' => auth()->user()->id,
                // 'modified_by' => auth()->user()->id
            ]);

            return redirect('/console/reward')->with('success', 'Success, create new reward');

        } else {

            return redirect('/console/reward')->with('failed', 'Failed, upload attachment');

        }

    }


    public function Detail(Request $request)
    {
        $get = SiteReward::query()->where('id', $request->reward_id)->first();
        return $get;
    }

    public function Delete(Request $request)
    {
        $Update = SiteReward::where('id', $request->reward_id)->update([
            'status' => 'deleted',
        ]);

        return redirect('/console/reward')->with('success', 'Success, deleted reward');
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
                $Update = SiteReward::where('id', $request->reward_id)->update([
                    'reward_name' => $request->reward_name,
                    'reward_point' => $request->reward_point,
                    'reward_description' => $request->keterangan,
                    'status' => $request->status,
                    'reward_cover' => $attachment,
                ]);

                return redirect()->back()->with('success', 'Success, Update reward');
            }else{
                return redirect()->back()->with('failed', 'Failed, upload attachment');
            }
            
        }else{
            $Update = SiteReward::where('id', $request->reward_id)->update([
                'reward_name' => $request->reward_name,
                'reward_point' => $request->reward_point,
                'reward_description' => $request->keterangan,
                'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Success, Update reward');
        }

    }


}
