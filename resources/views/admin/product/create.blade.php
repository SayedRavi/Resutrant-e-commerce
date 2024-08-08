@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Product</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control select2">
                            <option value="">-- Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" name="price" class="form-control" value="{{old('price')}}">
                    </div>

                    <div class="form-group">
                        <label for="offer_price">Offer Price</label>
                        <input type="text" name="offer_price" class="form-control" value="{{old('offer_price')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer_price">Quantity</label>
                        <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}">
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea name="short_description" id="" cols="30" rows="10" class="form-control">{{old('short_description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="long_description">Long Description</label>
                        <textarea name="long_description" id="" cols="30" rows="10" class="summernote">{{old('long_description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="sku">SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{old('sku')}}">
                    </div>

                    <div class="form-group">
                        <label for="seo_title">SEO Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{old('seo_title')}}">
                    </div>
                    <div class="form-group">
                        <label for="seo_description">SEO Description</label>
                        <textarea name="seo_description" id="" cols="30" rows="10" class="form-control">{{old('seo_description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="show_at_home" class="form-control">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
