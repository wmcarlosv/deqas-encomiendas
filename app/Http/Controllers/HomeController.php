<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Shipment;
use Session;

class HomeController extends Controller
{
    public function store(Request $request){
        $shop = $request->shop;
        if(isset($shop) and !empty($shop)){
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

                    $scopes = 'read_orders,write_orders,read_products,write_products,read_customers,read_checkouts,write_customers,write_checkouts';

                    $redirectUrl = env('SHOPIFY_URL_REDIRECT').'/install';
                    $redirect = \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl, null, null, true);
                    return redirect($redirect);
                }
        }else{
            return redirect()->route('login');
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

        $shopify = \PHPShopify\ShopifySDK::config($config);

        /*$webhook_data = array(
            'topic'=>'orders/create',
            'address'=>env('SHOPIFY_URL_REDIRECT').'/webhook/order',
            'format'=>'json'
        );

        $shopify->Webhook()->post($webhook_data);*/

        return view('store.index', compact('config'));
    }

    public function index()
    {
        $stores = Store::all();
        $shipments = Shipment::all();
        return view('admin.dashboard',compact('stores','shipments'));
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

    public function print_sticker($code){
        $data = Shipment::where('shipment_code','#'.$code)->get();
        return view('store.print', compact('data'));
    }

    public function webhook_order(Request $request){
        $data = file_get_contents('php://input');
        $the_data = json_decode($data);
        file_put_contents('order.json', $the_data->customer->first_name." ".$the_data->customer->last_name);

        $isDecas = false;
        foreach($the_data->shipping_lines as $shl){
            if($shl->code == 'Deqas'){
                $isDecas = true;
                break;
            }
        }

        if($isDecas){
            $shipment = new Shipment();
            $shipment->shipment_code = $the_data->name;
            $shipment->addressee = $the_data->billing_address->name;
            $shipment->customer_name = $the_data->customer->first_name." ".$the_data->customer->last_name;
            $shipment->address = $the_data->billing_address->address1;
            $shipment->comune = $the_data->billing_address->city;
            $shipment->region = $the_data->billing_address->province;
            $shipment->country = $the_data->billing_address->country;
            $shipment->contact_phone = $the_data->customer->phone;
            $shipment->contact_email = $the_data->customer->email;
            $shipment->save();
        }
    }

    public function webhook_order_update(Request $request){
        
    }
}
