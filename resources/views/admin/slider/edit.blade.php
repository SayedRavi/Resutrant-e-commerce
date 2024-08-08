@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Slider</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.slider.update', $slider->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="offer">Offer</label>
                        <input type="text" name="offer" class="form-control" value="{{$slider->offer}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$slider->title}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Sub Title</label>
                        <input type="text" name="sub_title" class="form-control" value="{{$slider->sub_title}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Short Discription</label>
                        <textarea name="short_description" class="form-control">{{$slider->short_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="offer">Button Link</label>
                        <input type="text" name="button_link" class="form-control" value="{{$slider->button_link}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" @selected($slider->status === 1)>Active</option>
                            <option value="0" @selected($slider->status === 0)>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script !src="">
        $(document).ready(function (){
            $('.image-preview').css({
                'background-image' : 'url({{$slider->image}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
