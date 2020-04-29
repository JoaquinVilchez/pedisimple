<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Invitation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/email/verify';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function commerceRegister($token)
    {
        $person = Invitation::where('token', $token)->first();
        return view('auth.register')->with('person', $person);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
    
        event(new Registered($user = $this->create($request->all())));
    
        // $this->guard()->login($user);
    
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'=> ['required', 'string'],
            'last_name'=> ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $invitation = Invitation::where('token', $data['token'])->first();
        $invitation->update(['state'=>'used']);
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone']
        ]);

        return $user;
    }
}
