<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Invitation;
use App\Rules\validatePhone;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;


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
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', new validatePhone],
            'g-recaptcha-response' => 'recaptcha',
        ]);
    }
    // 
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $phone = validatePhone($data['phone']);

        if (isset($data['token'])) {
            $invitation = Invitation::where('token', $data['token'])->first();
            $invitation->update(['state' => 'used']);
            $type = 'merchant';
        } else {
            $type = 'customer';
        }

        $user = User::create([
            'first_name' => ucfirst($data['first_name']),
            'last_name' => ucfirst($data['last_name']),
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'characteristic' => $phone['area'],
            'phone' => $phone['local'],
            'type' => $type
        ]);

        if ($type == 'customer') {
            $user->assignRole('customer');
        } elseif ($type == 'merchant') {
            $user->assignRole('merchant');
        }

        return $user;
    }
}
