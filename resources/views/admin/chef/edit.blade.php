@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Chef </h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.chef.update', $chef->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                                <input type="hidden" name="old_image" value="{{$chef->image}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$chef->name}}">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$chef->title}}">
                    </div>
                    <h5>Social Links </h5>
                    <div class="form-group">
                        <label for="facebook">Facebook<code>(Leave empty to hide)</code></label>
                        <input type="text" name="fb" class="form-control" value="{{$chef->fb}}">
                    </div>
                    <div class="form-group">
                        <label for="x">X<code>(Leave empty to hide)</code></label>
                        <input type="text" name="x" class="form-control" value="{{$chef->x}}">
                    </div>
                    <div class="form-group">
                        <label for="linkedin">Linkedin<code>(Leave empty to hide)</code></label>
                        <input type="text" name="in" class="form-control" value="{{$chef->in}}">
                    </div>
                    <div class="form-group">
                        <label for="web">Web<code>(Leave empty to hide)</code></label>
                        <input type="text" name="web" class="form-control" value="{{$chef->web}}">
                    </div>

                    <div class="form-group">
                        <label for="show_at_home">Show at Home</label>
                        <select name="show_at_home" class="form-control">
                            <option @selected($chef->show_at_home === 1) value="1">Yes</option>
                            <option @selected($chef->show_at_home === 0) value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($chef->status === 1) value="1">Active</option>
                            <option @selected($chef->status === 0) value="0">Inactive</option>
                        </select>
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
                'background-image' : 'url(/{{$chef->image}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
