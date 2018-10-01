<?php

namespace App\Listeners;

use App\Events\AccessDetection;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeTextListener
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
     * @param  AccessDetection  $event
     * @return void
     */
    public function handle(AccessDetection $event)
    {
        //
        $file = sprintf('%s/%s.txt', storage_path('texts'), date('Ymd-His'));
        touch($file);

        $current = file_get_contents($file);
        $current .= $event->param;
        
        file_put_contents($file, $current);
    }
}
