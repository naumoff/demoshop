<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

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
    protected $redirectTo = '/home';

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_phone' => 'required',
            'country' => 'required',
            'secret_word' => [
                'required',
                'string',
                'min:6',
                Rule::exists('secret_words')->where(function ($query){
                    $query->where('status','=','active');
                })
            ],
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
        $name = $data['first_name'].' '.$data['last_name'];
        $newUser = [
            'role_id'=> Role::getRoleId(config('roles.customer.en')),
            'name' => $name,
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'email' => $data['email'],
            'mobile_phone'=>$data['mobile_phone'],
            'country'=>$data['country'],
            'status'=>config('lists.user_status.pending.en'),
            'password' => bcrypt($data['secret_word'].$_ENV['SALT']),
        ];
        return User::create($newUser);
    }
    
    #region SERVICE METHODS
    private function saveGreetingMessageToSession()
    {
    
    }
    #endregion
}
