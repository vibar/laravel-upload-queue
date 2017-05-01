<?php

namespace Tests\Unit;


use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;
use App\Product;
use App\Services\ParserService;
use Tests\TestCase;

class ParseServiceTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $mock;

    public function setUp()
    {
        parent::setUp();

        $this->mock = \Mockery::mock(SpreadsheetParser::class);
        $this->app->instance(SpreadsheetParser::class, $this->mock);
    }

    public function testParse()
    {
        $products = factory(Product::class, 6)->make()->toArray();

        $path = base_path('products.xlsx');

        $this->mock->shouldReceive('open')
            ->once()
            ->with($path)
            ->andReturnSelf();
        ;

        $this->mock->shouldReceive('getWorksheets')
            ->once()
            ->andReturn(['plan1'])
        ;

        $this->mock->shouldReceive('createRowIterator')
            ->once()
            ->andReturn($products)
        ;

        $service = new ParserService($this->mock);

        $data = $service->parse($path, 3);

        $this->assertTrue(is_array($data));
    }
}