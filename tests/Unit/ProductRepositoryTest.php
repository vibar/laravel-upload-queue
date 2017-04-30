<?php

namespace Tests\Unit;


use App\Product;
use App\Repositories\ProductRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var \Mockery\MockInterface
     */
    private $mock;

    public function setUp()
    {
        parent::setUp();

        $this->mock = \Mockery::mock(Product::class);
        $this->app->instance(Product::class, $this->mock);
    }

    public function testFind()
    {
        $product = factory(Product::class)->create();

        $this->mock->shouldReceive('findOrFail')
            ->once()
            ->with($product->id)
            ->andReturn($product);

        $repository = new ProductRepository($this->mock);

        $this->assertEquals($product, $repository->find($product->id));
    }

    public function testAll()
    {
        $products = factory(Product::class, 5)->create();

        $this->mock->shouldReceive('select')
            ->once()
            ->with(['*'])
            ->andReturnSelf();

        $this->mock->shouldReceive('orderBy')
            ->once()
            ->with('id', 'asc')
            ->andReturnSelf();

        $this->mock->shouldReceive('get')
            ->once()
            ->andReturn($products);

        $repository = new ProductRepository($this->mock);

        $this->assertEquals($products, $repository->all());
    }

    public function testUpdate()
    {
        $product = factory(Product::class)->create();

        $name = 'test-name';
        $attributes = ['name' => $name];

        $this->mock->shouldReceive('findOrFail')
            ->once()
            ->with($product->id)
            ->andReturnSelf();

        $this->mock->shouldReceive('fill')
            ->once()
            ->with($attributes)
            ->andReturnSelf();

        $this->mock->shouldReceive('save')
            ->once()
            ->andReturn(true);

        $repository = new ProductRepository($this->mock);

        $this->assertTrue($repository->update($product->id, $attributes));
    }

    public function testDelete()
    {
        $product = factory(Product::class)->create();

        $this->mock->shouldReceive('findOrFail')
            ->once()
            ->with($product->id)
            ->andReturnSelf();

        $this->mock->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $repository = new ProductRepository($this->mock);

        $repository->delete($product->id);

        $this->mock->shouldReceive('findOrFail')
            ->once()
            ->with($product->id);

        $this->assertEmpty($repository->find($product->id));
    }

    public function testImport()
    {
        $products = factory(Product::class, 5)->create();
        $key = 'lm';

        foreach ($products as $product) {
            $this->mock->shouldReceive('firstOrNew')
                ->once()
                ->with([$key => $product->$key])
                ->andReturnSelf();

            $this->mock->shouldReceive('fill')
                ->once()
                ->with($product->toArray())
                ->andReturn($product);

            $this->mock->shouldReceive('save')
                ->once()
                ->andReturn(true);
        }

        $repository = new ProductRepository($this->mock);

        $repository->import($products->toArray(), $key);

        // all

        $this->mock->shouldReceive('select')
            ->once()
            ->with(['*'])
            ->andReturnSelf();

        $this->mock->shouldReceive('orderBy')
            ->once()
            ->with('id', 'asc')
            ->andReturnSelf();

        $this->mock->shouldReceive('get')
            ->once()
            ->andReturn($products);

        $this->assertEquals($products, $repository->all());
    }

}