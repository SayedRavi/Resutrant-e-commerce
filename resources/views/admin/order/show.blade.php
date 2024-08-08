@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Order Preview</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('admin.dashboard')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Invoice</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{$order->invoice_id}}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Delivered To:</strong><br>
                                        <strong>Name:</strong> {{@$order->userAddress->first_name}}{{@$order->userAddress->last_name}}
                                        <br>
                                        <strong>Phone:</strong> {{@$order->userAddress->phone }}
                                        <br>
                                        <strong>Address: </strong> {{@$order->userAddress->address}}
                                        <br>
                                        <strong>Area:</strong> {{@$order->userAddress->deliveryArea->area_name}}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{date('F d, Y / H:i', strtotime($order->created_at))}}
                                        <br><br>
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Payment Method:</strong>
                                        {{@$order->payment_method}}<br>
                                        <strong>Payment Status:</strong>
                                        @if (strtoupper(@$order->payment_status) === 'COMPLETED')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif(@$order->payment_status === 'pending')
                                            <span class="badge badge-danger">Pending</span>
                                        @else
                                            <span class="badge badge-warning">{{@$order->payment_status}}</span>
                                        @endif
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        @if (strtoupper(@$order->order_status) === 'COMPLETED')
                                         <span class="badge badge-success">Completed</span>
                                        @elseif(@$order->order_status === 'pending')
                                        <span class="badge badge-danger">Pending</span>
                                        @else
                                        <span class="badge badge-warning">{{@$order->order_status}}</span>
                                        @endif
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Optional Items</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>

                                    @foreach($order->orderItems as $orderItem)
                                        @php
                                        $size = json_decode($orderItem->product_size);
                                        $options = json_decode($orderItem->product_option);

                                        $quantity = $orderItem->quantity;
                                        $unitPrice = $orderItem->unit_price;
                                        $sizePrice = $size->price ?? 0;
                                        $optionPrice = 0;
                                        foreach ($options as $option){
                                            $optionPrice += $option->price;
                                        }
                                        $productTotal = ($unitPrice * $quantity) + $sizePrice + $optionPrice;
                                        @endphp
                                        <tr>
                                            <td>{{++$loop->index}}</td>
                                            <td>{{$orderItem->product_name}}</td>
                                            <td class="text-center">{{currencyPosition($orderItem->unit_price)}}</td>
                                            <td class="text-center">{{$size->name}} {{currencyPosition($size->price)}}</td>
                                            <td class="text-center">
                                            @foreach($options as $option)
                                                {{$option->name}} {{currencyPosition($option->price)}}
                                                    <br>
                                                @endforeach
                                                </td>
                                            <td class="text-center">1</td>
                                            <td class="text-right">{{currencyPosition($productTotal)}}</td>
                                        </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="col-md-4 d-print-none">
                                        <form action="{{route('admin.order.status.update',$order->id)}}" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <div class="form-group">
                                                <label for="">Payment Status</label>
                                                <select class="form-control" name="payment_status" id="">
                                                    <option @selected($order->payment_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->payment_status === 'completed') value="completed">Completed</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Order Status</label>
                                                <select class="form-control" name="order_status" id="">
                                                    <option @selected($order->order_status === 'pending') value="pending">Pending</option>
                                                    <option @selected($order->order_status === 'in_process') value="in_process">In Process</option>
                                                    <option @selected($order->order_status === 'delivered') value="delivered">Delivered</option>
                                                    <option @selected($order->order_status === 'declined') value="declined">Declined</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{currencyPosition(@$order->sub_total)}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Delivery</div>
                                        <div class="invoice-detail-value">{{currencyPosition($order->delivery_charge)}}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Discount</div>
                                        <div class="invoice-detail-value">{{currencyPosition($order->discount)}}</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{currencyPosition($order->grand_total)}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    <div class="float-lg-left mb-lg-0 mb-3">

                    </div>
                    <button class="btn btn-warning btn-icon icon-left" id="print_btn"><i class="fas fa-print"></i> Print</button>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        $(document).ready(function (){
                $('#print_btn').on('click',function (){
                    let printContent = $('.invoice-print').html();
                    let bootstrapUrl = `{{asset("admin/assets/modules/bootstrap/css/bootstrap.min.css")}}`;

                    let printWindow = window.open('', '', 'width=600,height=600');
                    printWindow.document.open();
                    printWindow.document.write('<html>');
                    printWindow.document.write('<link rel="stylesheet" href="'+bootstrapUrl+'" id="bootstrap-css">');
                    printWindow.document.write('<body>');
                    printWindow.document.write(printContent);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();

                    let bootstarpCssLink = printWindow.document.getElementById('bootstrap-css');
                    bootstarpCssLink.onload = function (){
                        printWindow.print();
                        printWindow.close();
                    }
                });
        })
    </script>
@endpush
