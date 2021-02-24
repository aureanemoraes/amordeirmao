<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Director;
use App\Models\Manager;
use App\Models\Quality;
use Backpack\CRUD\app\Http\Controllers\Auth\RegisterController as BackpackRegisterController;
use Illuminate\Support\Arr;
use Validator;


class RegisterController extends BackpackRegisterController
{
    //
    protected function validator(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();
        $users_table = $user->getTable();

        $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']);
        $data['number_of_phone'] = preg_replace('/[^0-9]/', '', $data['number_of_phone']);

        return Validator::make($data, [
            'name'                              => 'required|max:255',
            'email'                             => 'required|max:255|unique:'.$users_table,
            'password'                          => 'required|min:6|confirmed',
            'quality_id'                          => 'required',
            'zip_code' => 'max:8',
            'public_place' => 'required|max:255',
            'number' => 'required|max:10',
            'neighborhood' => 'required|max:255',
            'reference_place' => 'max:255',
            'uf' => 'required|max:2',
            'number_of_phone' => 'required|size:11',
            'type_of_phone' => 'required|max:255',
            'number_of_phone_2' => 'max:11',
            'type_of_phone_2' => 'max:255',
            backpack_authentication_column()    => 'required|size:11|unique:'.$users_table,
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model_fqn = config('backpack.base.user_model_fqn');
        $user = new $user_model_fqn();

        return $user->create([
            'name'                             => $data['name'],
            backpack_authentication_column()   => $data[backpack_authentication_column()],
            'password'                         => bcrypt($data['password']),
            'email'                              => $data['email'],
            'quality_id' => $data['quality_id']
        ]);
    }

    public function showRegistrationForm()
    {
        if (! config('backpack.base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }

        $qualities = Quality::all();
        $managers = Manager::join('users', 'managers.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.cpf')->get();
        $directors = Director::join('users', 'directors.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.cpf')->get();

        //dd($directors, $managers);

        $this->data['title'] = trans('backpack::base.register'); // set the page title

        return view(backpack_view('auth.register'), $this->data)
            ->with('qualities', $qualities)
            ->with('directors', $directors)
            ->with('managers', $managers);
    }
}
