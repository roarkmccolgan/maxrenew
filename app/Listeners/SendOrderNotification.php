<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\SendOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderNotification 
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $addressess = config('maxrenew.'.env('APP_ENV','local').'_order_emails');
        Mail::to($addressess)
            ->queue(new SendOrder($event->order));
        }
}
