<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use App\Rules\validatePhone;

class UserController extends Controller
{

    public function ownerData(Request $request)
    {
        $user = User::find($request->id);

        return view('admin.restaurant.modal_info')->with('user', $user);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkoutLogin(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], false)) {
            return response()->json('Bienvenido', 200);
        } else {
            return response()->json(['errors' => 'Los datos ingresados no son correctos.'], 422);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('user.account')->with('user', $user);
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
        request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => ['required', new validatePhone],
        ]);

        $user = User::findOrFail($id);
        $phone = validatePhone($request->phone);

        if ($request->hasFile('image')) {

            $old_image = $user->image;

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);

            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            if ($old_image != 'user.png') {
                $path_old_image = 'images/uploads/user/' . $old_image;
                if (file_exists($path_old_image)) {
                    unlink($path_old_image);
                }
            }

            $file->store('public/uploads/user');

            $user->update(['image' => $path]);
        }


        if ($request->hasFile('image')) {
            $old_image = $user->image;

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->fit(785, 785, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(785, 785)->encode('jpg', 75);

            if ($old_image != 'user.png') {
                Storage::delete('public/uploads/user/' . $old_image);
            }

            Storage::put("public/uploads/user/" . $path, $image->__toString());

            $user->image = $path;
        } elseif ($request->hasFile('image') == "" && $user->image != "user.png") {
            Storage::delete('public/uploads/user/' . $user->image);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'characteristic' => $phone['area'],
            'phone' => $phone['local']
        ]);

        return redirect(route('user.index'))->with('success_message', 'Datos editados con éxito');
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
