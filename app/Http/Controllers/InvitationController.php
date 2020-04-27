<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use Carbon\Carbon;

class InvitationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request){
        $invitation = Invitation::where('id', $request->invitationid)->first();

        $invitation->update(['state' => 'without-using']);

        Mail::to($invitation->email)->send(new InvitationMail($invitation, $invitation->token));

        return redirect()->route('invitation.index')->with('success_message', 'Invitacion reenviada con exito');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = Invitation::all();
        return view('admin.invitation.list')->with('invitations', $invitations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.invitation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | email',
        ]);

        $token = bcrypt(Carbon::now());    
        $token = str_replace ('/', 'P', $token);
        $token = str_replace ('$', 'S', $token);

        Invitation::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'token' => $token
        ]);

        $person = Invitation::where('email', $request->email)->first();
        
        Mail::to($request->email)->send(new InvitationMail($data, $person->token));

        return redirect()->route('invitation.index')->with('success_message', 'Invitación enviada con éxito');
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
