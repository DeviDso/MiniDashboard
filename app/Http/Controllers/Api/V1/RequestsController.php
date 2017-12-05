<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\ClientRequest;
use App\User;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
        $cr = ClientRequest::with('client')
                ->with('requestStatus')
                ->with('requestType')
                ->get();

        return $cr;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'client_id' => 'required',
            'user_id' => 'required',
            'request_type_id' => 'required',
            'request_status_id' => 'required'
            ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::find($request->input('user_id'));
        $req = $user->clientRequest()->create($request->all());

        return $req;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cr = ClientRequest::find($id);

        return $cr->with('client')
                ->with('requestStatus')
                ->with('requestType')
                ->where('id', $id)
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
            'request_type_id' => 'required',
            'request_status_id' => 'required',
            ]);

        if($validator->fails()){
            return response()->with($validator->errors(), 400);
        }

        $req = ClientRequest::findOrFail($id);
        $req->update($request->all());

        return $req;
    }

    /**
     * Remove the specified resource from sto2rage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $r)
    {
        $user = User::firstOrFail($r->input('user_id'));

        $user->clientRequest()
            ->where('id', $id)
            ->delete();

        return '';
    }
}
