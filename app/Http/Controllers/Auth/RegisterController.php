<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\EmailConfirmation;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'address' => $data['address']
        ]);
        
        if ($user)
            $email_confirmation_url = config('app.url') . '/confirmation?param1=' . $user->id . '&param2=' . $user->password;
            Mail::to($user->email)->send(new EmailConfirmation($user, $email_confirmation_url));
            return $user;        
    }

    //Este metodo es una sobreescritura del metodo original (polimorfismo) ya que lo sobreescribimos para introducir en el registro los datos del nombre y correo del futuro usuario. No hace falta crear una ruta porque laravel ya la tiene en sus archivos Vendor y podemos llamar el metodo desde /register
    public function showRegistrationForm(Req $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        return view('auth.register')->with(compact('name', 'email'));
    }
}
