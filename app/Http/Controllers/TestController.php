<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use App\Models\Test;
use App\Notifications\DeliveryStatusNotification;
use App\Notifications\OrderStatusNotification;
use Carbon\Carbon;
use Hamcrest\Type\IsArray;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{


    public function status()
    {
        // $url = "https://demo.nepalcanmove.com/api/v1/order/comment?id=1918";

        // $address = [
        //         "name" => "Ram ji",
        //         "email" => "name@domain.com",
        //         "phone" => "980000500",
        //         "address" => "Koteshwor, Mahadevsthan",
        //         "branch" => "BIRATNAGAR",
        //         "cod_charge" => 0
        // ];

        // // // return $address;
        // $response = Http::withHeaders([
        //     "Accept" => "application/json",
        //     "Authorization" => "Token f972f6719f0a33cab5896a9d684190aac5d8232e",
        // ])
        //     ->post("https://demo.nepalcanmove.com/api/v1/order/create", $address);
        // return $response;

        
        $url = "https://demo.nepalcanmove.com/api/v1/order?id=1921";

        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Authorization" => "Token f972f6719f0a33cab5896a9d684190aac5d8232e",
        ])
            ->get($url);
        
        return $response;




        // code below is working
        $status = ['REQUESTED', 'PICKED', 'PROCESSED', 'PENDING'];
        $orderStatus = OrderProduct::whereIn('delivery_status', $status)
            ->orWhereNull('delivery_status')
            ->whereNotNull('requested_at')
            ->get();
        

        foreach ($orderStatus as $os) {
          
            $url = "https://delivery.anubhabi.com/api/orders/track/" . $os->tracking_id;

            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->get($url);

            if ($response->successful()) {
                $a = json_decode($response);
                if ($a->status = "success") {
                    if ($a->data->delivery_status != $os->delivery_status) {
                        OrderProduct::where('id', $os->id)->update([
                            'delivery_status' => strtoupper($a->data->delivery_status),
                            'pickup_at' => $a->data->pickup_date,
                            'delivered_at' => $a->data->delivery_date
                        ]);
                    }
                }
                if ($a->data->delivery_status=="PICKED" || $a->data->delivery_status=="DELIVERED"){
            
                    $os->customers->notify(new DeliveryStatusNotification($os));
                }
            }
        }
    }


    public function store(Request $request)
    {
        $test = new Test;
        if ($request->f != csrf_token()) {
            dd('Please stop messing arround');
        } else {
            dd($request); // to debug request
            // dd($request->ip());
            $test->data = json_encode($request->d);
            $test->save();
        }
    }

    public function view()
    {
        return view('test');
    }

    public function color()
    {
        return view('color');
    }

    public function deliveries()
    {

        $url = "https://delivery.anubhabi.com/api/addresses";


        //     # Make the call using API.
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "accept: application/json",
            "apikey: j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            "Content-Type: application/json"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // var_dump($resp);
        return $resp;
    }

    public function postDelivery()
    {
        $address = [
            "address" => [
                "name" => "Ram ji",
                "email" => "name@domain.com",
                "mobile" => "9800000000",
                "address" => "Koteshwor, Mahadevsthan",
                "district" => "1",
                "latitude" => "28.3698",
                "longitude" => "27.2544",
                "pinCode" => "44600"
            ]
        ];

        // // return $address;
        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
        ])
            ->post('https://delivery.anubhabi.com/api/addresses', $address);
        return $response;


        // $response = Http::withHeaders([
        //     "accept" => "application/json",
        //     "apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
        // ])
        // ->get('https://delivery.anubhabi.com/api/addresses');

        // return $response;

        // Make Post Fields Array
        $data = '{"address":{ "name": "Ram Ji", "email": "name@domain.com", "mobile": "9800000000", "address": "Koteshwor, Mahadevsthan", "district": "1", "latitude": "28.3698", "longitude": "27.2544", "pinCode": "44600"}}';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://delivery.anubhabi.com/api/addresses",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: application/json",
                "apikey: j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
                "content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            print_r(json_decode($response));
        }

        // above is new

        $url = "https://delivery.anubhabi.com/api/addresses";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "accept: application/json",
            "apikey: j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            "Content-Type: application/json"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{"address":{ "name": "Ram Ji", "email": "name@domain.com", "mobile": "9800000000", "address": "Koteshwor, Mahadevsthan", "district": "1", "latitude": "28.3698", "longitude": "27.2544", "pinCode": "44600"}}';
        // $data = array(
        //     'address":{ "name": "Ram Ji", "email": "name@domain.com", "mobile": "9800000000", "address": "Koteshwor, Mahadevsthan", "district": "1", "latitude": "28.3698", "longitude": "27.2544", "pinCode": "44600"}'
        // );

        // return $data;

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }


    public function getOrders()
    {

        $url = "https://delivery.anubhabi.com/api/orders";

        //     # Make the call using API.
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "accept: application/json",
            "apikey: j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            "Content-Type: application/json"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // var_dump($resp);
        return $resp;
    }

    public function getOrder($id)
    {
        $url = "https://delivery.anubhabi.com/api/orders/" . $id;

        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
        ])
            ->get($url);
        return $response;
    }

    public function track($id)
    {
        $url = "https://delivery.anubhabi.com/api/orders/track/TGE-20211125-238866";

        $response = Http::withHeaders([
            "Accept" => "application/json",
            "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
        ])
            ->get($url);
        return $response;
    }




    public function postOrder()
    {
        $address = [
            "address" => [
                "name" => 'falana',
                "email" => 'dhiskano@gmail.com',
                "mobile" => '9860016848',
                "address" => 'imadol',
                "district" => 3,
                "latitude" => "28.3698",
                "longitude" => "27.2544",
                "pinCode" => 47005
            ]
        ];

        $deliveryResponse = Http::withHeaders([
            "Accept" => "application/json",
            "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
        ])
            ->post('https://delivery.anubhabi.com/api/addresses', $address);


        $postOrder = OrderProduct::where('requested_at', null)->where('status', 'Ready')->get();
        // return $postOrder;
        foreach ($postOrder as $post) {
            $a = json_decode($post->delivered->delivery);
            //return $a;

            $url = "https://delivery.anubhabi.com/api/districts";

            $response = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->get($url);

            $location = (array)$response['data'];

            $found_key = array_search($a->city, array_column($location, 'name'));

            // delivery address district
            $Address_id = $location[$found_key]['id'];


            // return $Address_id;



            $address = [
                "address" => [
                    "name" => $a->name,
                    "email" => $post->customers->email,
                    "mobile" => $a->contact,
                    "address" => $a->street,
                    "district" => $Address_id,
                    "latitude" => "28.3698",
                    "longitude" => "27.2544",
                    "pinCode" => $a->postal
                ]
            ];
            //return $post->studioes->user[0]['email'];
            $found_pickup_key = array_search($post->studioes->studioaddress->city, array_column($location, 'name'));

            // delivery address district
            $pickupId = $location[$found_pickup_key]['id'];


            $pickupAddress = [
                "address" => [
                    "name" => $post->studioes->user[0]['name'],
                    "email" => $post->studioes->user[0]['email'],
                    "mobile" => $post->studioes->studioaddress->contact,
                    "address" => $post->studioes->studioaddress->street,
                    "district" => $pickupId,
                    "latitude" => "28.3698",
                    "longitude" => "27.2544",
                    "pinCode" => $post->studioes->studioaddress->postal
                ]
            ];


            $deliveryResponse = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->post('https://delivery.anubhabi.com/api/addresses', $address);

            $pickupResponse = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->post('https://delivery.anubhabi.com/api/addresses', $pickupAddress);





            $order = [
                "order" => [
                    "pickupAddress" => $pickupResponse['data']['id'],
                    "deliveryAddress" => $deliveryResponse['data']['id'],
                    "packageWeight" => "1.5",
                    "packageTotalItems" => "1",
                    "packageOrderAmount" => $post->price * $post->quantity,
                    "pickupDate" => "2021-12-12T10:44:30.535Z",
                    "note" => "Deliver in evening",
                ]
            ];

            $orderResponse = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->post('https://delivery.anubhabi.com/api/orders', $order);

            // OrderProduct::where('id', $post->id)->update(['requested_at' => Carbon::now()]);


            return $orderResponse;
        }
    }
}
