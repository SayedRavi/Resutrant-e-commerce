@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Categories</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Category</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.category.update', $item->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$item->name}}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="show_at_home" class="form-control">
                            <option @selected($item->show_at_home === 1) value="1">Yes</option>
                            <option @selected($item->show_at_home === 0) selected value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($item->status === 1) value="1">Active</option>
                            <option @selected($item->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
