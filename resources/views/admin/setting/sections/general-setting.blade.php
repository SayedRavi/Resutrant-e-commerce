<div class="tab-pane fade show active" id="genral-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border-2">
            <form action="{{route('admin.general-setting.update')}}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="">Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{config('settings.site_name')}}">
                </div>
                <div class="form-group">
                    <label for="">Default Currency</label>
                    <select name="site_default_currency" id="" class="form-control select2">
                        <option value="">--Select Currency</option>
                        @foreach(config('currencies.currency_list') as $currency)
                            <option @selected(config('settings.site_default_currency') === $currency) value="{{$currency}}">{{$currency}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Currency Icon</label>
                        <input type="text" class="form-control" name="site_currency_icon" value="{{config('settings.site_currency_icon')}}">
                    </div>
                    <div class="col-md-6">
                        <label for="">Currency Position</label>
                        <select name="site_currency_position" id="" class="form-control select2">
                            <option @selected(config('settings.site_currency_position') === 'right') value="right">Right</option>
                            <option @selected(config('settings.site_currency_position') === 'left') value="left">Left</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>
</div>
