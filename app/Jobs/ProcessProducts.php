<?php

namespace App\Jobs;


use App\Contracts\Services\ParserInterface;
use App\Events\ProductsImported;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $filename;

    /**
     * Create a new job instance.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     * @param ParserInterface $parser
     */
    public function handle(ParserInterface $parser)
    {
        Log::info('Process products job: '.$this->filename);

        $path = storage_path().'/app/spreadsheets/'.$this->filename;

        $data = $parser->open($path, 3)->get();

        foreach ($data as $row) {
            // TODO: validate rows

            $product = Product::firstOrNew(['lm' => $row['lm']]);
            $product->fill($row);
            $product->save();
        }

        Log::info('Products imported.');

        event(new ProductsImported($this->filename));
    }
}
