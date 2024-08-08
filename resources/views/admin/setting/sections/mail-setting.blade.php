<div class="tab-pane fade" id="mail-setting" role="tabpanel" aria-labelledby="contact-tab4">

    <div class="card">
        <div class="card-body border-2">
            <form action="{{route('admin.mail-setting.update')}}" method="post">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mail Driver</label>
                            <input type="text" class="form-control" name="mail_driver" value="{{config('settings.mail_driver')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mail Host</label>
                            <input type="text" class="form-control" name="mail_host" value="{{config('settings.mail_host')}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mail Port</label>
                            <input type="text" class="form-control" name="mail_port" value="{{config('settings.mail_port')}}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail User Name</label>
                            <input type="text" class="form-control" name="mail_user_name" value="{{config('settings.mail_user_name')}}">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Mail Password</label>
                            <input type="text" class="form-control" name="mail_password" value="{{config('settings.mail_password')}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="">Mail Encryption</label>
                    <input type="text" class="form-control" name="mail_encryption" value="{{config('settings.mail_encryption')}}">
                </div>

                <div class="form-group">
                    <label for="">Application Email</label>
                    <input type="text" class="form-control" name="app_email" value="{{config('settings.app_email')}}">
                </div>
                <div class="form-group">
                    <label for="">Sender/Customer Email</label>
                    <input type="text" class="form-control" name="customer_email" value="{{config('settings.customer_email')}}">
                </div>


                <button class="btn btn-primary mt-3">Save</button>
            </form>
        </div>
    </div>

</div>
