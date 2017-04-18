<?php

namespace Tests\Unit;

use App\Jobs\ProcessProducts;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductTest extends TestCase
{
    use DatabaseTransactions;

    private $filename;

    public function setUp()
    {
        parent::setUp();

        $this->filename = 'products.xlsx';
    }

    public function testStorage()
    {
        Storage::fake('spreadsheets');

        $response = $this->post('/product', [
            'file' => UploadedFile::fake()->create('products.xlsx', 1024),
        ]);

        // TODO: test exceptions: mimes, maxsize...

        $response->assertStatus(200);

        // Assert the file was stored...
        Storage::disk('spreadsheets')->assertExists('products.xlsx');
    }

    public function testProcessProductsQueue()
    {
        Queue::fake();

        $this->post('/product', [
            'file' => UploadedFile::fake()->create($this->filename, 1024)
        ]);

        Queue::assertPushed(ProcessProducts::class, function ($job) {
            return $job->filename === $this->filename;
        });
    }

    public function testProcessProductsJob()
    {
        Bus::fake();

        $this->post('/product', [
            'file' => UploadedFile::fake()->create($this->filename, 1024)
        ]);

        Bus::assertDispatched(ProcessProducts::class, function ($job) {
            return $job->filename === $this->filename;
        });
    }

    public function testProductsImportedEvent()
    {
        Event::fake();

        $this->post('/product', [
            'file' => UploadedFile::fake()->create('products.xlsx', 1024)
        ]);

        Event::assertDispatched(ProcessProducts::class, function ($e) {
            return $e->filename === $this->filename;
        });
    }
}
