@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>All Blogs</h4>
                <div class="card-header-action">
                    <a href="{{route('admin.blog.create')}}" class="btn btn-primary">
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
