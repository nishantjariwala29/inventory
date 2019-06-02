@extends('layouts.app')
@section('title', 'Create')
@section('content')
    <div class="container">
        <div class="float-right">
            <a href="{{url('/products/create')}}" class="btn btn-primary">New Product</a>
        </div>
        <h3>Products List</h3>
        <hr/>
        {!! Form::open(['method'=>'get']) !!}
        <div class="row">
            <div class="col-sm-5 form-group">
                <div class="input-group">
                    <input class="form-control" id="search"
                           value="{{ request('search') }}"
                           placeholder="Search name" name="search"
                           type="text" id="search"/>
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-warning">
                            Search
                        </button>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{request('field')}}" name="field"/>
            <input type="hidden" value="{{request('sort')}}" name="sort"/>
        </div>
        {!! Form::close() !!}
        <table class="table table-bordered bg-light">
            <thead>
            <tr>
                <th>ID</th>
                <th>
                    <a href="{{url('products')}}?search={{request('search')}}&field=product_name&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                        Name
                    </a>
                    {!! request('field','name')=='product_name'?(request('sort','asc')=='asc'?'<span class="caret"></span>':""):'' !!}
                </th>
                <th>Description</th>
                <th>
                    <a href="{{url('products')}}?search={{request('search')}}&field=product_qty&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                        Qty
                    </a>
                    {!! request('field','name')=='product_qty'?(request('sort','asc')=='asc'? "<span class='caret'></span>":''):'' !!}
                </th>
                <th>
                    <a href="{{url('products')}}?search={{request('search')}}&field=product_price&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                        Price
                    </a>
                    {!! request('field','name')=='product_price'?(request('sort','asc')=='asc'?'<span class="caret"></span>':''):''!!}
                </th>

                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @if($products->count())
                @php
                    $i=1;
                @endphp
                @foreach($products as $product)
                    <tr>
                        <th>{{$i++}}</th>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->product_description }}</td>
                        <td>{{ $product->product_qty }}</td>
                        <td>{{ $product->product_price }}</td>
                        <td align="center">
                            <form id="form_{{ $product->id}}"
                                  action="{{url('products/delete/'.$product->id)}}"
                                  method="post" style="padding-bottom: 0px;margin-bottom: 0px">
                                <a class="btn btn-primary btn-sm" title="Edit"
                                   href="{{url('products/'.$product->id.'/edit')}}">
                                    Edit</a>
                                <input type="hidden" name="_method" value="delete"/>
                                {{csrf_field()}}
                                <a class="btn btn-danger btn-sm" title="Delete"
                                   href="javascript:if(confirm('Are you sure want to delete?')) $('#form_{{$product->id}}').submit()">
                                    Delete
                                </a>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <td colspan="6" class="text-center">No products found</td>
            @endif
            </tbody>
        </table>
        <nav>
            <ul class="pagination justify-content-end">
                {!! $products->render() !!}
            </ul>
        </nav>
    </div>
@endsection