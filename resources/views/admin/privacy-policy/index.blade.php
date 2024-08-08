@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Privacy Policy</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Privacy Policy</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.privacy-policy.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="summernote" id="" cols="30" rows="10">{!! @$privacy->content !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
