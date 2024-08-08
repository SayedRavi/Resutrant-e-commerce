@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Product Gallery - ({{$product->name}})</h1>
        </div>
        <a href="{{route('admin.product.index')}}" class="btn btn-primary btn-sm my-2">Go Back</a>
        <div class="card card-primary">
            <div class="card-body">
                <div class="col-md-8">
                    <form action="{{route('admin.product-gallery.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                            <input type="hidden" value="{{$product->id}}" name="product_id">
                        </div>
                        <button class="btn btn-primary">Upload</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-body">
                <table class="table tab-bordered normal_table">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($images) < 1)
                        <tr>
                            <td colspan="2" class="text-center" ><p class="text-danger">No Images Found</p></td>
                        </tr>
                    @else
                        @foreach($images as $image)

                            <tr>
                                <td><img src="{{asset($image->image)}}" width="150px" alt=""></td>
                                <td><a href='{{route('admin.product-gallery.destroy', $image->id)}}' class='btn btn-sm btn-danger delete-item ml-2'><i class='fas fa-trash'></i></a></td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

            </div>
        </div>
    </section>
@endsection

