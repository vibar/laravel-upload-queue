@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Product edit #{{ $product->id }}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('product.update', $product->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="lm" class="col-md-4 control-label">LM</label>

                            <div class="col-md-6">
                                <input id="lm" type="text" class="form-control" name="lm" value="{{ old('lm') ?: $product->lm }}" required autofocus maxlength="10">

                                @if ($errors->has('lm'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?: $product->name }}" required maxlength="100">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">Category</label>

                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" value="{{ old('category') ?: $product->category }}" required maxlength="20">

                                @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Price</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control" name="price" value="{{ old('price') ?: $product->price }}" required>

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('free_shipping') ? ' has-error' : '' }}">
                            <label for="free_shipping" class="col-md-4 control-label">Free shipping</label>

                            <div class="col-md-6">

                                @php ($free_shipping = old('free_shipping') ?: $product->free_shipping)

                                <select name="free_shipping" id="free_shipping" id="free_shipping" class="form-control" required>
                                    <option value="0" {{ $free_shipping == 0 ? 'selected' : '' }}>no</option>
                                    <option value="1" {{ $free_shipping == 1 ? 'selected' : '' }}>yes</option>
                                </select>

                                @if ($errors->has('free_shipping'))?: $product->price
                                    <span class="help-block">
                                        <strong>{{ $errors->first('free_shipping') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
