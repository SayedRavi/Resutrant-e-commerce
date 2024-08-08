@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Coupon</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.coupon.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="offer">Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Code</label>
                        <input type="text" name="code" class="form-control" value="{{old('code')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Quantity</label>
                        <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Minimum Purchase Amount</label>
                        <input type="text" name="min_purchase_amount" class="form-control" value="{{old('min_purchase_amount')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Expire Date</label>
                        <input type="date" name="expire_date" class="form-control" value="{{old('expire_date')}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Discount Type</label>
                        <select name="discount_type" class="form-control">
                            <option value="1">percentage (%)</option>
                            <option value="0">{{currencyPosition(' Amount ')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="offer">Discount</label>
                        <input type="text" name="discount" class="form-control" value="{{old('discount')}}">
                    </div>

                    <div class="form-group">
                        <label for="offer">Status</label>
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
