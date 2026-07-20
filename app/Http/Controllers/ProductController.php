<?php
 
namespace App\Http\Controllers;

use App\Models\SiteProduct;
use App\Models\SiteProductGroup;
use App\Models\SiteProductField;
use App\Models\SiteProductPrice;
use Illuminate\Http\Request;
 
use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
class ProductController extends Controller
{
    
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

    public function list(Request $request)
    {

        $product = SiteProduct::latest();

        $product->select('product_scope', 'product_type', 'site_product.id', 'product_name', 'product_plan', 'product_desc', 'site_product.is_hidden', 'site_product.created_at');
        // $product->leftjoin('site_product_group', 'site_product_group.id', '=', 'site_product.router_id');
        // $product->where('site_product.is_hidden', '=', '0');
        $product->orderByDesc('site_product.created_at');
        $product->omniFilter();

        $site_product_group = SiteProductGroup::query()->where('is_hidden', '=', '0')->get();

        return view('page/product', [
            'data' => $product->paginate(30)->withQueryString(),
            'site_product_group' => $site_product_group
        ]);

    }

    public function Create(Request $request)
    {

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

            $product_create = SiteProduct::create([
                'reseller_id' => session('reseller_id'),
                'product_name' => $request->product_name,
                'product_plan' => $request->product_plan,
                'product_desc' => $request->product_desc,
                'product_scope' => $request->product_scope,
                'product_group' => $request->product_group,
                'allow_promo' => $request->has('allow_promo') ? 1 : 0,
                'product_type' => $request->product_type,
                'is_hidden' => $request->is_hidden,
                'deposit_payment' => $request->has('deposit_payment') ? 1 : 0,
                'cover' => $attachment,
            ]);

            $billing_cycle = $request->billing_cycle;
            $setup_fee = $request->setup_fee;
            $price = $request->price;
            $enabled = $request->enabled ? $request->enabled : [];

            for($count = 0; $count < collect($billing_cycle)->count(); $count++)
            {
                $create_item = SiteProductPrice::create([
                    'product_id' => $product_create->id,
                    'payment_type' => $request->payment_type,
                    'billing_cycle' => $billing_cycle[$count],
                    'setup_fee' => $setup_fee[$count],
                    'price' => $price[$count],
                    'enabled' => in_array($billing_cycle[$count], $enabled) ? 1 : 0,
                ]);        
            }

            $field_name = $request->field_name;
            $order_number = $request->order_number;
            $field_type = $request->field_type;
            $select_options = $request->select_options;

            for($count = 0; $count < collect($field_name)->count(); $count++)
            {
                $create_item2 = SiteProductField::create([
                    'product_id' => $product_create->id,
                    'order' => $order_number[$count],
                    'field_name' => $field_name[$count],
                    'field_type' => $field_type[$count],
                    'select_options' => $select_options[$count],
                    'field_slug' => Str::slug($field_name[$count], '-'),
                    'is_required' => '1',
                    'show_order_form' => '1',
                ]);        
            }

            return redirect()->back()->with('success', 'Success, create new product');

        } else {

            return redirect()->back()->with('failed', 'Failed, upload cover is mandatory');

        }

        

    }

    public function Detail(Request $request)
    {
        $get = SiteProduct::query()
        ->select('product_group_name', 'product_scope', 'site_product.id', 'product_name', 'product_plan', 'product_desc', 'product_type', 'product_group', 'site_product.is_hidden', 'site_product.deposit_payment', 'site_product.created_at','allow_promo', 'cover')
        ->leftjoin('site_product_group', 'site_product_group.id', '=', 'site_product.product_group')
        ->where('site_product.id', $request->product_id)
        ->first();

        $price = SiteProductPrice::query()
        ->select('payment_type', 'billing_cycle', 'setup_fee', 'price', 'enabled')
        ->where('product_id', $request->product_id)
        ->get();

        $field = SiteProductField::query()
        ->where('product_id', $request->product_id)
        ->get();

        return ['prod' => $get,'price' => $price,'field' => $field];
    }

    public function Delete(Request $request)
    {
        $Update = SiteProduct::where('id', $request->product_id)->update([
            'is_hidden' => '1',
        ]);

        return redirect()->back()->with('success', 'Success, deleted product');
    }

    public function Update(Request $request)
    {

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

            $Update = SiteProduct::where('id', $request->product_id)->update([
                'cover' => $attachment,
            ]);

        }

        $Update = SiteProduct::where('id', $request->product_id)->update([
            'product_name' => $request->product_name,
            'product_plan' => $request->product_plan,
            'product_desc' => $request->product_desc,
            'product_scope' => $request->product_scope,
            'product_group' => $request->product_group,
            'allow_promo' => $request->has('allow_promo') ? 1 : 0,
            'product_type' => $request->product_type,
            'is_hidden' => $request->is_hidden,
            'deposit_payment' => $request->has('deposit_payment') ? 1 : 0,
        ]);

        $billing_cycle = $request->billing_cycle;
        $setup_fee = $request->setup_fee;
        $price = $request->price;
        $enabled = $request->enabled ? $request->enabled : [];

        $delete_item = SiteProductPrice::where('product_id', (int) $request->product_id)->delete();
        
        for($count = 0; $count < collect($billing_cycle)->count(); $count++)
        {
            $create_item = SiteProductPrice::create([
                'product_id' => $request->product_id,
                'payment_type' => $request->payment_type,
                'billing_cycle' => $billing_cycle[$count],
                'setup_fee' => $setup_fee[$count],
                'price' => $price[$count],
                'enabled' => in_array($billing_cycle[$count], $enabled) ? 1 : 0,
            ]);        
        }

        $field_name = $request->field_name;
        $order_number = $request->order_number;
        $field_type = $request->field_type;
        $select_options = $request->select_options;

        $delete_item2 = SiteProductField::where('product_id', (int) $request->product_id)->delete();

        for($count = 0; $count < collect($field_name)->count(); $count++)
        {
            // Hanya simpan select_options jika field_type adalah selectbox
            $select_option_value = ($field_type[$count] == 'selectbox' && isset($select_options[$count])) 
                                 ? $select_options[$count] 
                                 : null;
            
            $create_item2 = SiteProductField::create([
                'product_id' => $request->product_id,
                'order' => $order_number[$count],
                'field_name' => $field_name[$count],
                'field_type' => $field_type[$count],
                'select_options' => $select_option_value,
                'field_slug' => Str::slug($field_name[$count], '-'),
                'is_required' => '1',
                'show_order_form' => '1',
            ]);        
        }

        return redirect()->back()->with('success', 'Success, Update product');
    }

    public function get_product_group(Request $request) {

        $get = SiteProductGroup::where('product_group_headline', $request->product_group_headline)->where('is_hidden', (int)0)->orderBy('id','asc')->get();

        return $get;
    }

    public function get_product_plan(Request $request) {

        $get = SiteProduct::where('product_group', $request->group_id)->orderBy('order','asc')->get();

        return $get;
    }

    public function get_product_price(Request $request) {

        $get = SiteProductPrice::query()->select('price')->where('product_id', (int) $request->product_id)->first();

        if(!empty($get)) {
            return $get;
        } else {
            return json_encode(["price" => 0]);
        }

    }

    public function get_product_field(Request $request) {

        $get = SiteProductField::where('product_id', $request->product_id)->orderBy('order','asc')->get();

        return $get;
    }

    public function get_billing_cycle(Request $request) {

        $get = SiteProductPrice::query()->select('id', 'billing_cycle')->where('product_id', (int) $request->product_id)->where('enabled', '1')->get();
        return $get;

    }

    public function get_billing_price(Request $request) {

        $get = SiteProductPrice::query()->select('price', 'setup_fee')->where('billing_cycle', (int) $request->billing_id)->where('product_id', (int) $request->product_id)->where('enabled', '1')->first();
        if(!empty($get)) {
            return $get;
        } else {
            return json_encode(["price" => 0, "setup_fee" => 0]);
        }
    }

}
