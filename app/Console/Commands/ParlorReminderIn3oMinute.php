<?php

namespace App\Console\Commands;

use App\Models\ParlorTicket;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\ParlorReminderNotification;
use Carbon\Carbon;

class ParlorReminderIn3oMinute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:parlorreminderin30min';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Push notification to parlor';

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
        $tickets=ParlorTicket::with(['parlor.host','sells'=>function ($query) {
            // $query->whereBetween('created_at', [Carbon::now(), Carbon::now()->addHours(8)]);
             }])
            // ->whereBetween('time', [Carbon::now(), Carbon::now()->addMinutes(30)])
            ->where('time', '<=', Carbon::now()->addMinutes(30))
            ->where('time', '>', Carbon::now()->addMinutes(25))
            //  ->whereHas('sells')
             ->get();
           
          
             foreach($tickets as $ticket){
                 $user = $ticket->sells->pluck('user_id');
                 $hostid = $ticket->parlor->host->id;
                 $host = User::find($hostid);
                 $host->notify(new ParlorReminderNotification($ticket,$host));
                 $users=User::whereIn('id',$user)->get();
                 foreach($users as $u){                  
                  $u->notify(new ParlorReminderNotification($ticket,$u));
                 }
             }
             
    }
}
