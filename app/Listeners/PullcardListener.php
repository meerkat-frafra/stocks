<?php

namespace App\Listeners;

use App\Events\PullcardDetection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PullcardListener
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
     * @param  PullcardDetection  $event
     * @return void
     */
    public function handle(PullcardDetection $event)
    {
        //
        $card = $event->card;
    }
}
