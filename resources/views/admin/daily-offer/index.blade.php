@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Offer</h1>
        </div>
        <div class="card">
            <div class="card-body">
                <div id="accordion">
                    <div class="accordion">
                        <div class="accordion-header collapsed bg-primary text-light" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="false">
                            <h4>Daily Offers Titles..</h4>
                        </div>
                        <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion" style="">
                            <form action="{{route('admin.dailyOffer.updateTitle')}}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="top_title">Top Title</label>
                                    <input type="text" class="form-control"
                                           name="daily_offer_top_title" value="{{@$title['daily_offer_top_title']}}">
                                </div>
                                <div class="fomr-group">
                                    <label for="main_title">Main Title</label>
                                    <input type="text" class="form-control"
                                           name="daily_offer_main_title" value="{{@$title['daily_offer_main_title']}}" >
                                </div>
                                <div class="form-group">
                                    <label for="sub_title">Sub Title</label>
                                    <input type="text" class="form-control"
                                           name="daily_offer_sub_title" value="{{@$title['daily_offer_sub_title']}}">
                                </div>
                                <button class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="section">
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Daily Offer</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.daily-offer.create')}}" class="btn btn-primary">
                        Create New
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table()}}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('.table').attr('width', '100%');
    </script>
@endpush
