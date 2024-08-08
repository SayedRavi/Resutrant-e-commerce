<div class="tab-pane fade" id="razorpay-setting" role="tabpanel" aria-labelledby="home-tab4">
    <div class="card">
        <div class="card-body border-2">
            <form action="{{route('admin.razorpay.setting.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="">Razorpay Status</label>
                    <select name="razorpay_status" id="" class="form-control select2">
                        <option @selected(@$paymentGateway['razorpay_status'] === 1) value="1">Active</option>
                        <option @selected(@$paymentGateway['razorpay_status'] === 0) value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Razorpay Country Name</label>
                    <select name="razorpay_country_name" id="" class="form-control select2">
                        <option value="sandbox">--Select Country --</option>
                        @foreach(config('country_list') as $key => $country)
                            <option @selected(@$paymentGateway['razorpay_country_name'] === $key) value="{{$key}}">{{$country}}</option>
                        @endforeach

                    </select>
                </div>
                <div class="form-group">
                    <label for="">Razorpay Currency Name (Per {{config('settings.site_default_currency')}})</label>
                    <select name="razorpay_currency_name" id="" class="form-control select2">
                        <option value="">--Select Currency</option>
                        @foreach(config('currencies.currency_list') as $currency)
                            <option @selected(@$paymentGateway['razorpay_currency_name'] === $currency) value="{{$currency}}">{{$currency}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Currency Rate</label>
                    <input type="text" class="form-control" name="razorpay_rate" value="{{@$paymentGateway['razorpay_rate']}}">
                </div>
                <div class="form-group">
                    <label for="">Razorpay Client ID</label>
                    <input type="text" class="form-control" name="razorpay_api_key" value="{{@$paymentGateway['razorpay_api_key']}}">
                </div>
                <div class="form-group">
                    <label for="">Razorpay Secret Key</label>
                    <input type="text" class="form-control" name="razorpay_secret_key" value="{{@$paymentGateway['razorpay_secret_key']}}">
                </div>

                <div class="form-group">
                    <div class="col-sm-12 col-md-7">
                        <div id="image-preview-3" class="image-preview razorpay-preview">
                            <label for="image-upload-3" id="image-label-3">Choose File</label>
                            <input type="file" name="razorpay_logo" id="image-upload-3">
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>
</div>
@push('scripts')
    <script !src="">
        $(document).ready(function (){
            $('.razorpay-preview').css({
                'background-image' : 'url({{@$paymentGateway['razorpay_logo']}})',
                'background-size' : 'cover',
                'background-position' : 'center center'
            });
        });
        $.uploadPreview({
            input_field: "#image-upload-3",   // Default: .image-upload
            preview_box: "#image-preview-3",  // Default: .image-preview
            label_field: "#image-label-3",    // Default: .image-label
            label_default: "Choose File",   // Default: Choose File
            label_selected: "Change File",  // Default: Change File
            no_label: false,                // Default: false
            success_callback: null          // Default: null
        });
    </script>
@endpush
