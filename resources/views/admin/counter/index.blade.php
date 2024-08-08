@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Counter</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Update Counters</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.counter.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <div class="col-sm-12 col-md-7">
                            <label for="background">Background</label>
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="background" id="image-upload">
                                <input type="hidden" name="old_background" value="{{@$counter->background}}">
                            </div>
                        </div>
                    </div>
                    <h6>Counter One</h6>
                    <hr>
                    <div class="form-group">
                        <label for="name">Icon</label>
                        <button role="iconpicker" name="counter_icon_one" class="btn btn-primary" data-icon="{{$counter->counter_icon_one}}"></button>
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Count One</label>
                        <input type="text" name="counter_count_one" class="form-control" value="{{$counter->counter_count_one}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Name One</label>
                        <input type="text" name="counter_name_one" class="form-control" value="{{$counter->counter_name_one}}">
                    </div>

                    <h6>Counter Two</h6>
                    <hr>
                    <div class="form-group">
                        <label for="name">Icon</label>
                        <button role="iconpicker" name="counter_icon_two" class="btn btn-primary" data-icon="{{$counter->counter_icon_two}}"></button>
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Count Two</label>
                        <input type="text" name="counter_count_two" class="form-control" value="{{$counter->counter_count_two}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Name Two</label>
                        <input type="text" name="counter_name_two" class="form-control" value="{{$counter->counter_name_two}}">
                    </div>

                    <h6>Counter Three</h6>
                    <hr>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <button role="iconpicker" name="counter_icon_three" class="btn btn-primary" data-icon="{{$counter->counter_icon_three}}"></button>
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Count Three</label>
                        <input type="text" name="counter_count_three" class="form-control" value="{{$counter->counter_count_three}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Name Three</label>
                        <input type="text" name="counter_name_three" class="form-control" value="{{$counter->counter_name_three}}">
                    </div>

                    <h6>Counter Four</h6>
                    <hr>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <button role="iconpicker" name="counter_icon_four" class="btn btn-primary" data-icon="{{$counter->counter_icon_four}}"></button>
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Count Four</label>
                        <input type="text" name="counter_count_four" class="form-control" value="{{$counter->counter_count_four}}">
                    </div>
                    <div class="form-group">
                        <label for="name">Counter Name Four</label>
                        <input type="text" name="counter_name_four" class="form-control" value="{{$counter->counter_name_four}}">
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
                'background-image' : 'url(/{{$counter->background}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
    </script>
@endpush
