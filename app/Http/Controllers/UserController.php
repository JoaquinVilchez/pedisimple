<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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
            'characteristic' => 'required',
            'phone' => 'required',
        ]);

        $user = User::findOrFail($id);
        
        if($request->hasFile('image')){

            $old_image = $user->image;

            $file = $request->file('image');

            $path = $file->hashName();

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });
            
            if($old_image != 'user.png'){
                $path_old_image = 'images/uploads/user/'.$old_image;
                    if(file_exists($path_old_image)){
                        unlink($path_old_image);
                    }
            }    
            
            $image->save('images/uploads/user/'.$path);         

            $user->update(['image'=>$path]);  
        }


        if($request->hasFile('image')){
            $old_image = $user->image;

            $file = $request->file('image');

            $path = $file->hashName('');

            $image = Image::make($file)->encode('jpg', 75);
            
            $image->fit(250, 250, function ($constraint) {
                $constraint->aspectRatio();
            });

            if(!$old_image=='public/user.png'){
                Storage::delete($old_image);
            }
            Storage::put($path, (string) $image->encode());

            $user->image = $path;         
        }

        $user->update($request->only('first_name','last_name','email','phone'));

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
