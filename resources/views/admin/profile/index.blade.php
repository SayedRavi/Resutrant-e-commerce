@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
        </div>

        <div class="section-body">
            <div class="card-header">
                <h4>Update User Profile</h4>
                <div class="card-header-action">
                </div>
            </div>
            <form class="card card-primary" action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                <div class="card-body col-md-6">
                        @csrf
                        @method('PUT')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="avatar" id="image-upload">
                            </div>
                        </div>
                    </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{auth()->user()->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="{{auth()->user()->email}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
            </div>
            <div class="card-header">
                    <h4>Update Password</h4>
                    <div class="card-header-action">
                    </div>
                </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Update Password</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body col-md-6">
                    <form action="{{route('admin.password.update')}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>

    </section>
@endsection
@push('scripts')
    <script !src="">
        $(document).ready(function (){
            $('.image-preview').css({
                'background-image' : 'url({{asset(auth()->user()->avatar)}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
