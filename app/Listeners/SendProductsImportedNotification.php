<?php

namespace App\Listeners;

use App\Events\ProductsImported;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendProductsImportedNotification implements ShouldQueue
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
     * @param  ProductsImported  $event
     * @return void
     */
    public function handle(ProductsImported $event)
    {
        Log::info('Listener SendProductsImportedNotification: '.json_encode($event));
    }
}
