<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeclinedOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\InProcessOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPlacedNotifaction;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.index');
    }
    function pendingOrderIndex(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.order-pending');

    }
    function inProcessOrderIndex(InProcessOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.in-process-order');

    }
    function deliveredOrderIndex(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered-order');

    }
    function declinedOrderIndex(DeclinedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.declined-order');

    }
    function show(string $id)
    {
        $order = Order::findOrFail($id);
        $notification = OrderPlacedNotifaction::where('order_id', $order->id)->update(['seen' => 1]);
        return view('admin.order.show',compact('order'));

    }

    function getOrderStatus(string $id){
    $order = Order::select(['order_status', 'payment_status'])->findOrFail($id);

    return response($order);
    }


    function orderStatusUpdate(Request $request, string $id)
    {
        $request->validate([
            'payment_status' => ['required', 'in:completed,pending'],
            'order_status' => ['required', 'in:pending,in_process,delivered,declined'],
        ]);
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => $request->payment_status,
            'order_status' => $request->order_status
        ]);
        if ($request->ajax()){
            return response(['message'=> 'Order Status Updated Successfully!']);
        }else{
            toastr()->success('Updated Successfully');
            return redirect()->back();
        }

    }
    function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return response(['message'=> 'Deleted Successfully', 'status' => 'success']);
        }
        catch (\Exception $error){
            logger($error);
            dd($error);
            return response(['message' => 'Something Went Wrong!', 'status'=> 'error']);
        }
    }
}
