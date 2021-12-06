<?php

namespace App\Console\Commands;

use App\Models\OrderProduct;
use App\Notifications\DeliveryStatusNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class OrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:orderstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Order Status';

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
        $status = ['REQUESTED', 'PICKED', 'PROCESSED', 'PENDING'];
        $orderStatus = OrderProduct::whereIn('delivery_status', $status)
            ->orWhereNull('delivery_status')
            ->whereNotNull('requested_at')
            ->get();
        // return $orderStatus;

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
}
