<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Order;
use App\Client;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        return Order::where('confirmed', 1)->with(['client', 'status', 'data', 'user'])->orderBy('created_at', 'DSC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'client_id' => 'required',
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $client = Client::find($request->input('client_id'));
        $order = $client->orders()->create($request->all());

        $order->confirmed = 1;
        $order->save();

        if($request->input('data')){
            $orderData = $order->data()->createMany($request->input('data'));
        }

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::with(['client', 'user'])
                ->where('id', $id)
                ->with(['status', 'data', 'data.product',])
                ->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'client_id' => 'required',
            'status_id' => 'required',
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $order = Order::find($id);

        $order->update($request->all());
        $order->data()->delete();
        $order->data()->createMany($request->input('data'));
        // $client = Client::find($request->input('client_id'));
        // $order = $client->orders()->where('order.id', $id)->update($request->all());
        // $orderData = $order->data()->createMany($request->input('data'));

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return '';
    }
}
