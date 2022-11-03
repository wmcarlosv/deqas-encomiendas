<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Session;

class HomeController extends Controller
{
    public function store(Request $request){
        $shop = $request->shop;
        $store = Store::where('store_url',$shop)->first();
        if($store){
            $store = Store::findorfail($store->id);
            return redirect()->route('the_home',['shop_url'=>$store->store_url, 'access_token'=>$store->access_token]);
        }else{
            $config = array(
                'ShopUrl' => $shop,
                'ApiKey' => env('SHOPIFY_API_KEY'),
                'SharedSecret' => env('SHOPIFY_SHARED_SECRET'),
            );

            \PHPShopify\ShopifySDK::config($config);

            $scopes = 'read_orders,read_products';
            $redirectUrl = env('SHOPIFY_URL_REDIRECT').'/install';
            $redirect = \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl, null, null, true);
            return redirect($redirect);
        }
    }

    public function install(Request $request){
       $shop = $request->shop;
       $config = array(
            'ShopUrl' => $shop,
            'ApiKey' => env('SHOPIFY_API_KEY'),
            'SharedSecret' => env('SHOPIFY_SHARED_SECRET'),
        );

        \PHPShopify\ShopifySDK::config($config);
        $accessToken = \PHPShopify\AuthHelper::getAccessToken();

        $store = Store::where('access_token',$accessToken)->first();
        if($store){
            $store = Store::findorfail($store->id);
            return redirect()->route('the_home',['shop_url'=>$store->store_url, 'access_token'=>$store->access_token]);
        }else{
            $store = new Store();
            $store->store_url = $shop;
            $store->access_token = $accessToken;
            $store->save();
            return redirect('https://'.$shop.'/admin/apps/package-delivery');
        }

        
    }

    public function the_home($shop_url, $access_token){
        $config = array(
            'ShopUrl' => $shop_url,
            'AccessToken' => $access_token,
            'ApiVersion' => '2022-07'
        );

        return view('store.index', compact('config'));
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function orders(Request $request){
        $config = array(
            'ShopUrl' => $request->ShopUrl,
            'AccessToken' => $request->AccessToken,
            'ApiVersion' => $request->ApiVersion
        );

        $shopify = \PHPShopify\ShopifySDK::config($config);

        $orders = $shopify->Order->get();

        return response()->json($orders);
    }

    public function print_sticker($customer, $address, $phone){
        $data = [
            'customer'=>$customer,
            'address'=>$address,
            'phone'=>$phone
        ];

        return view('store.print', compact('data'));
    }
}
