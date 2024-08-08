@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chefs</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create chef</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.chef.store')}}" method="post" enctype="multipart/form-data">
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
                        <label for="title">Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <h5>Social Links </h5>
                    <div class="form-group">
                        <label for="facebook">Facebook<code>(Leave empty to hide)</code></label>
                        <input type="text" name="fb" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="x">X<code>(Leave empty to hide)</code></label>
                        <input type="text" name="x" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="linkedin">Linkedin<code>(Leave empty to hide)</code></label>
                        <input type="text" name="in" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="web">Web<code>(Leave empty to hide)</code></label>
                        <input type="text" name="web" class="form-control">
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
