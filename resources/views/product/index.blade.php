@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                    <span class="pull-right">
                        @if (count($products))
                            {{ count($products) }}
                            {{ count($products) == 1 ? 'item' : 'items' }}
                        @endif
                    </span>
                </div>

                <div class="panel-body">

                    @if (count($products))

                    <table class="table">
                        <thead>
                            <tr>
                                <th>LM</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Shipping</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($products as $product)

                            <tr>
                                <th scope="row">{{ $product->lm }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->free_shipping }}</td>
                                <td>
                                    <form method="POST" action="{{ route('product.destroy', $product->id) }}" onsubmit="return confirm('Are you sure you want to delete?')">
                                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-default">edit</a>
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-sm btn-default">delete</button>
                                    </form>
                                </td>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>

                    @else

                    <p>
                        <a href="{{ route('product.create') }}">
                            Import your products
                        </a>
                    </p>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
