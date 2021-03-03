<?php

namespace App\Http\Controllers;

use App\MailSubscription;
use Illuminate\Http\Request;
use NZTim\Mailchimp\Mailchimp;

class MailSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'email' => 'required|email|unique:mail_subscriptions'
        ]);

        if ($request->type == "merchant") {
            $mc = new Mailchimp(env('MC_KEY'));
            $listId = env('MAILCHIMP_MERCHANT_LIST_ID');
            $emailAddress = $request->email;
            $mc->subscribe($listId, $emailAddress, $merge = [], false);
        }

        MailSubscription::create([
            'email' => $request->email,
            'type' => $request->type
        ]);

        $message = "¡Listo! Te enviaremos novedades sobre la plataforma, gracias.";
        $alertStyle = "success_message";

        return redirect()->route('app.maintenance')->with($alertStyle, $message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
