@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Testimonials</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Testimonial</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.testimonial.update', $testimonial->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                                <input type="hidden" name="old_image" value="{{$testimonial->image}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{$testimonial->name}}">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$testimonial->title}}">
                    </div>
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea name="review" class="form-control" id="" cols="30" rows="10">{{$testimonial->review}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" class="form-control">
                            <option @selected($testimonial->rating === 1) value="1">1</option>
                            <option @selected($testimonial->rating === 2) value="2">2</option>
                            <option @selected($testimonial->rating === 3) value="3">3</option>
                            <option @selected($testimonial->rating === 4) value="4">4</option>
                            <option @selected($testimonial->rating === 5) value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="show_at_home">Show at Home</label>
                        <select name="show_at_home" class="form-control">
                            <option @selected($testimonial->show_at_home === 1) value="1">Yes</option>
                            <option @selected($testimonial->show_at_home === 0) value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($testimonial->status === 1) value="1">Active</option>
                            <option @selected($testimonial->status === 0) value="0">Inactive</option>
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
                'background-image' : 'url(/{{$testimonial->image}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
