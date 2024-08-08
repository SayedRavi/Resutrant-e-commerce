@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Testimonials</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Testimonial</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.testimonial.store')}}" method="post" enctype="multipart/form-data">
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
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea name="review" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <select name="rating" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="show_at_home">Show at Home</label>
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
