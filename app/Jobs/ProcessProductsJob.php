<?php

namespace App\Jobs;


use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\ParserInterface;
use App\Events\ProductsImported;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const PARSER_OFFSET_ROW = 3;
    const PRODUCT_KEY = 'lm';

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string
     */
    private $path;

    /**
     * Create a new job instance.
     *
     * @param string $filename
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
        $this->path = storage_path().'/app/spreadsheets/'.$this->filename;
    }

    /**
     * Execute the job.
     * @param \App\Contracts\Repositories\ProductRepositoryInterface $productRepository
     * @param \App\Contracts\Services\ParserInterface $parser
     */
    public function handle(ProductRepositoryInterface $productRepository, ParserInterface $parser)
    {
        $products = $parser->open($this->path, self::PARSER_OFFSET_ROW)->extract();
        $productRepository->import($products, self::PRODUCT_KEY);

        event(new ProductsImported($this->filename));
    }
}
