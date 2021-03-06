<?php

namespace App\Http\Controllers\api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\Client;
use Validator;

class QuotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::where('confirmed', 0)->with(['data', 'client', 'user'])->get();
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
        $quote = $client->orders()->create($request->all());

        if($request->input('data')){
            $quoteData = $quote->data()->createMany($request->input('data'));
        }

        return $quote;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Order::where('id', $id)
                ->with(['data', 'client', 'user'])
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
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $quote = Order::find($id);

        $quote->update($request->all());
        $quote->data()->delete();
        $quote->data()->createMany($request->input('data'));

        return $quote;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Order::findOrFail($id);
        $quote->delete();

        return '';
    }
}
