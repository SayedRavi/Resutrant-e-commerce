@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Setting</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Settings</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-2">
                        <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="gernral_setting" data-toggle="tab" href="#genral-setting" role="tab" aria-controls="home" aria-selected="true">General Setting</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pusher_setting" data-toggle="tab" href="#pusher-setting" role="tab" aria-controls="profile" aria-selected="false">Pusher Setting</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="mail_setting" data-toggle="tab" href="#mail-setting" role="tab" aria-controls="contact" aria-selected="false">Mail Setting</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-12 col-md-10">
                        <div class="tab-content no-padding" id="myTab2Content">
                            @include('admin.setting.sections.general-setting')

                            @include('admin.setting.sections.pusher-setting')

                            @include('admin.setting.sections.mail-setting')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

