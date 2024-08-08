@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Terms and Conditions</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Terms and Conditions</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.terms-and-conditions.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" class="summernote" id="" cols="30" rows="10">{!! @$terms->content !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </section>
@endsection
