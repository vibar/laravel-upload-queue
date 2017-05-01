<?php

namespace App\Jobs;


use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\ParserServiceInterface;
use App\Events\ProductsImported;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $this->path = config('parser.path').$this->filename;
    }

    /**
     * Execute the job.
     * @param \App\Contracts\Repositories\ProductRepositoryInterface $productRepository
     * @param \App\Contracts\Services\ParserServiceInterface $parser
     */
    public function handle(ProductRepositoryInterface $productRepository, ParserServiceInterface $parser)
    {
        $products = $parser->parse($this->path, 3);
        $productRepository->import($products, 'lm');

        event(new ProductsImported($this->filename));
    }
}
