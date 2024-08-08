@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Slider</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.contact.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="phone_one">Phone One</label>
                        <input type="text" name="phone_one" class="form-control" value="{{@$contact->phone_one}}">
                    </div>

                    <div class="form-group">
                        <label for="phone_two">Phone Two</label>
                        <input type="text" name="phone_two" class="form-control" value="{{@$contact->phone_two}}">
                    </div>

                    <div class="form-group">
                        <label for="email_one">Email One</label>
                        <input type="text" name="email_one" class="form-control" value="{{@$contact->email_one}}">
                    </div>

                    <div class="form-group">
                        <label for="email_two">Email Two</label>
                        <input type="text" name="email_two" class="form-control" value="{{@$contact->email_two}}">
                    </div>


                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" name="address" class="form-control" value="{{@$contact->address}}">
                    </div>


                    <div class="form-group">
                        <label for="map_link">Google Map Link</label>
                        <input type="text" name="map_link" class="form-control" value="{{@$contact->map_link}}">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
