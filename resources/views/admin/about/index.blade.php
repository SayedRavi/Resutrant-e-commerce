@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>About</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create About</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.about.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                                <input type="hidden" name="old_image" value="{{$about->image}}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="offer">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$about->title}}">
                    </div>
                    <div class="form-group">
                        <label for="main_title">Title Title</label>
                        <input type="text" name="main_title" class="form-control" value="{{$about->main_title}}">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="summernote">{{$about->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="offer">Youtube Video Link</label>
                        <input type="text" name="video_link" class="form-control" value="{{$about->video_link}}">
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
                'background-image' : 'url(/{{@$about->image}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
