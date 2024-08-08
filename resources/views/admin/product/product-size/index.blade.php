@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Variants - ({{$product->name}})</h1>
        </div>
        <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm my-2">Go Back</a>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Sizes</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{route('admin.product-sizes.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" class="form-control">
                                </div>
                            </div>

                            <button class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-body">
                        <table class="table tab-bordered normal_table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($sizes) < 1)
                                <tr>
                                    <td colspan="3" class="text-center" ><p class="text-danger">No Images Found</p></td>
                                </tr>
                            @else
                                @foreach($sizes as $size)

                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$size->name}}</td>
                                        <td>{{currencyPosition($size->price)}}</td>
                                        <td><a href='{{route('admin.product-sizes.destroy', $size->id)}}' class='btn btn-sm btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Create Product Options</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{route('admin.product-option.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" class="form-control">
                                </div>
                            </div>

                            <button class="btn btn-primary">Save</button>
                        </form>

                    </div>
                </div>
                <div class="card card-primary">

                    <div class="card-body">
                        <table class="table tab-bordered normal_table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($options) < 1)
                                <tr>
                                    <td colspan="3" class="text-center" ><p class="text-danger">No Images Found</p></td>
                                </tr>
                            @else
                                @foreach($options as $option)

                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$option->name}}</td>
                                        <td>{{currencyPosition($option->price)}}</td>
                                        <td><a href='{{route('admin.product-option.destroy', $size->id)}}' class='btn btn-sm btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

