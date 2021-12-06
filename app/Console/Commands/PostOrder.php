<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class PostOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:postorder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post Order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $postOrder = OrderProduct::where('requested_at', null)->where('status', 'Ready')->get();
        // return $postOrder;
        foreach ($postOrder as $post) {
            $a = json_decode($post->delivered->delivery);

            $destrictUrl = "https://delivery.anubhabi.com/api/districts";

            $districts = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->get($destrictUrl);


            // exit if response is not 200 < 300
            if (!$districts->successful()) {
                return;
            }
            // else

            $location = (array)$districts['data'];
            $found_key = array_search($a->city, array_column($location, 'name'));

            // delivery address district
            $destrictID = $location[$found_key]['id'];



            // Delivery address of the person
            $deliveryAddress = [
                "address" => [
                    "name" => $a->name,
                    "email" => $post->customers->email,
                    "mobile" => $a->contact,
                    "address" => $a->street,
                    "district" => $destrictID,
                    "latitude" => "28.3698",
                    "longitude" => "27.2544",
                    "pinCode" => $a->postal
                ]
            ];

            // Post delivery address to service provider ie. garuda
            $deliveryResponse = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->post('https://delivery.anubhabi.com/api/addresses', $deliveryAddress);

            if (!$deliveryResponse->successful()) {
                return;
            }


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


            $pickupResponse = Http::withHeaders([
                "Accept" => "application/json",
                "Apikey" => "j8ORHo9hadTX1AkGW1vDm-MK52wQPMoyKeq1guaxTKg",
            ])
                ->post('https://delivery.anubhabi.com/api/addresses', $pickupAddress);

            if (!$pickupResponse->successful()) {
                return;
            }

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

            if ($orderResponse->successful()) {
                // Update requested date, tracking-id, service provider name,;
                OrderProduct::where('id', $post->id)->update(['requested_at' => Carbon::now(),'tracking_id'=>$orderResponse['data']['number'],
                'service_provider'=>"The Garuda Express"]);

            }
            // return $orderResponse;
        }
    }
}
