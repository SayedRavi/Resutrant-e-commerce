<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>General Dashboard &mdash; Stisla</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('admin/assets/modules/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/bootstrap-iconpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/modules/summernote/summernote-bs4.css')}}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/css/components.css')}}">

    <link rel="stylesheet" href="{{asset('admin/assets/css/toastr.min.css')}}">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">


    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        var pusherKey = '{{config('settings.pusher_key')}}';
        var pusherCluster = '{{config('settings.pusher_cluster')}}';
        var loggedUserId = "{{auth()->user()->id ?? ''}}";

     </script>
    <!-- /END GA --></head>
@vite(['resources/js/app.js', 'resources/js/admin.js'])
<body>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        @include('admin.layouts.sidebar')
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
            </div>
            <div class="footer-right">

            </div>
        </footer>
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('admin/assets/modules/jquery.min.js')}}"></script>
<script src="{{asset('admin/assets/modules/popper.js')}}"></script>
<script src="{{asset('admin/assets/modules/tooltip.js')}}"></script>
<script src="{{asset('admin/assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('admin/assets/modules/moment.min.js')}}"></script>
<script src="{{asset('admin/assets/js/stisla.js')}}"></script>

<script src="{{asset('admin/assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('admin/assets/js/toastr.min.js')}}"></script>
<script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js" defer></script>
<script src="{{asset('admin/assets/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
<script src="{{asset('admin/assets/modules/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('admin/assets/modules/summernote/summernote-bs4.js')}}"></script>


<!-- Template JS File -->
<script src="{{asset('admin/assets/js/scripts.js')}}"></script>
<script src="{{asset('admin/assets/js/custom.js')}}"></script>


<script>
    toastr.options.progressBar = true;
    @if($errors->any)
    @foreach($errors->all() as $error)
    toastr.error('{{$error}}')
    @endforeach
    @endif
    $.uploadPreview({
        input_field: "#image-upload",   // Default: .image-upload
        preview_box: "#image-preview",  // Default: .image-preview
        label_field: "#image-label",    // Default: .image-label
        label_default: "Choose File",   // Default: Choose File
        label_selected: "Change File",  // Default: Change File
        no_label: false,                // Default: false
        success_callback: null          // Default: null
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var token = "{{ csrf_token() }}";
    $(document).ready(function (){
        $('body').on('click', '.delete-item',function (event){
            event.preventDefault()
            let  url = $(this).attr('href');
            console.log(url);
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {'_token': $('input[name="_token"]').val()},
                        success: function (response){
                            if (response.status === 'success'){
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                                if ($('.dataTable')){
                                    $('table').DataTable().draw();
                                }
                                else if ($('.normal_table'|| '.table')){
                                    window.location.reload();
                                }

                            }
                            else if (response.status === 'error'){
                                Swal.fire({
                                    title: response.status,
                                    text: response.message,
                                    icon: "success"
                                });
                            }
                        },
                        error: function (error){
                            console.log(error)
                        }
                    })

                }
            });
        })
    })
</script>
@stack('scripts')
</body>
</html>
