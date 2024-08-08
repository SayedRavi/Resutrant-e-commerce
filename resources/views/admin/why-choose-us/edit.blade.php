@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Why Choose Us</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Edit Why-Choose-Us</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.why-choose-us.update', $whyChooseItem->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="offer">Icons</label>
                        <br>
                        <button data-icon="{{$whyChooseItem->icon}}" class="btn btn-secondary text-white" name="icon" role="iconpicker">Icon</button>
                    </div>
                    <div class="form-group">
                        <label for="offer">Title</label>
                        <input type="text" name="title" class="form-control" value="{{$whyChooseItem->title}}">
                    </div>
                    <div class="form-group">
                        <label for="offer">Short Discription</label>
                        <textarea name="short_description" class="form-control">{{$whyChooseItem->short_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="offer">Status</label>
                        <select name="status" class="form-control">
                            <option @selected($whyChooseItem->status === 1) value="1">Active</option>
                            <option @selected($whyChooseItem->status === 0) value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </section>
@endsection
