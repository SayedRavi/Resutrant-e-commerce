@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Delivery Areas</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Edit Delivery Area</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.delivery-areas.update', $area->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">Area Name</label>
                        <input type="text" name="area_name" class="form-control" value="{{$area->area_name}}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Minimum Delivery Time</label>
                                <input type="text" name="min_delivery_time" class="form-control" value="{{$area->min_delivery_time}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Maximum Delivery Time</label>
                                <input type="text" name="max_delivery_time" class="form-control" value="{{$area->max_delivery_time}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Delivery Fee</label>
                                <input type="text" name="delivery_fee" class="form-control" value="{{$area->delivery_fee}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option @selected($area->status === 1) value="1">Active</option>
                                    <option @selected($area->status === 0) value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
