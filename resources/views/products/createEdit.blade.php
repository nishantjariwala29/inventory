@extends('layouts.app')
@section('title', 'Create')
@section('content')
    <div class="col-md-4 col-md-offset-4">
        <h1>{{isset($product)?'Edit':'New'}} Product</h1>

        <form @if(isset($product))
                action="{{ url('products/update/'. $id)}}" method="POST"
              @else
                action="{{ url('products')}}" method="POST"
              @endif>
            @csrf
            <div class="form-group">
                <label for="form-label">Product Name</label>
                <input type="text"
                       name="product_name"
                       id="product_name"
                       value="@isset($product) {{ $product->product_name }} @endisset" class="form-control" required>
                {!! $errors->first('product_name','<span class="error">:message</span>') !!}
            </div>
            <div class="form-group">
                <label for="form-label">Product Descriptio</label>
                <textarea type="text"
                          name="product_description"
                          id="product_description"
                          class="form-control" required>@isset($product){{ $product->product_description }}@endisset</textarea>
                {!! $errors->first('product_description','<span class="error">:message</span>') !!}
            </div>
            <div class="form-group">
                <label for="form-label">Product Qty</label>
                <input type="number"
                       name="product_qty"
                       id="product_qty"
                       value="@isset($product){{ $product->product_qty }}@endisset" class="form-control" required>
                {!! $errors->first('product_qty','<span class="error">:message</span>') !!}
            </div>
            <div class="form-group">
                <label for="form-label">Product Price</label>
                <input type="number"
                       name="product_price"
                       id="product_price"
                       value="@isset($product){{ $product->product_price }}@endisset" class="form-control" required>
                {!! $errors->first('product_price','<span class="error">:message</span>') !!}
            </div>
            <input type="submit" value="Submit" name="submit" class="btn btn-primary">
            <a href="{{ url('products') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
@endsection
