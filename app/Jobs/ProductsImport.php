<?php

namespace App\Jobs;

use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;
use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ShouldQueue
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
     */
    public function handle()
    {
        Log::info('Products Import job: '.$this->filename);

        $workbook = SpreadsheetParser::open(storage_path().'/app/spreadsheets/'.$this->filename);
        $columnsIndex = 3;

        foreach ($workbook->getWorksheets() as $index => $title) {

            $columns = [];

            // TODO: chunk

            foreach ($workbook->createRowIterator($index) as $row => $values) {

                if ($row < $columnsIndex) {
                    continue;
                }

                if ($row == $columnsIndex) { // columns
                    $columns = $values;
                    continue;
                }

                $item = array_combine($columns, $values);

                // TODO: validate rows

                $product = Product::firstOrNew(['lm' => $item['lm']]);
                $product->fill($item);
                $product->save();
            }
        }

        Log::info('Products imported.');
    }
}
