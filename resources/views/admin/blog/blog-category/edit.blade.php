@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog Category</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Blog Category</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.blog-category.update', $category->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$category->name}}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($category->status === 1) value="1">Active</option>
                            <option @selected($category->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
