@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daily Offers</h1>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                <h4>Create Daily Offer</h4>
            </div>
            <div class="card-body">
                <form action="{{route('admin.daily-offer.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="status">Product</label>
                        <select name="product_id" id="product_search" class="form-control">
                            <option value="">Select</option>
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
@push('scripts')
    <script>
        $(document).ready(function (){
            $('#product_search').select2({
                ajax: {
                    url: '{{route('admin.daily-offer.search')}}',
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data){
                        return{
                            results: $.map(data, function(product){
                                return {
                                    text : product.name,
                                    id: product.id,
                                    image_url : product.thumb_image
                                }
                            })
                        }
                    }
                },
                minimumInputLength: 3,
                templateResult: formatProduct,
                escapeMarkup : function (m){
                    return m;
                }
            });
            function formatProduct(product){
                var product = $('<span><img src="/'+product.image_url+'" width="50px">'+product.text+'</span>')
                return product;
            }
        })
    </script>
@endpush
