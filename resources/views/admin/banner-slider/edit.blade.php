@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Banner Sliders</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Banner Slider</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.banner-slider.update', $bannerSlider->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                                <input type="hidden" name="old_image" value="{{$bannerSlider->banner}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$bannerSlider->title}}">
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Sub Title</label>
                        <input type="text" name="subtitle" class="form-control" value="{{$bannerSlider->subtitle}}">
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Url</label>
                        <input type="text" name="url" class="form-control" value="{{$bannerSlider->url}}">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($bannerSlider->status === 1) value="1">Active</option>
                            <option @selected($bannerSlider->status === 0) value="0">Inactive</option>
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
                'background-image' : 'url(/{{$bannerSlider->banner}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
