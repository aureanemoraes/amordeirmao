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

        return Validator::make($data, [
            'name'                              => 'required|max:255',
            'email'                             => 'required|max:255|unique:'.$users_table,
            'password'                          => 'required|min:6|confirmed',
            'quality_id'                          => 'required',
            backpack_authentication_column()    => 'required|max:11|unique:'.$users_table,
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
            ->select('users.name')->get()->toArray();
        $directors = Director::join('users', 'directors.user_id', '=', 'users.id')
            ->select('users.name')->get()->toArray();

        $responsables = Arr::collapse($managers, $directors);

        dd($responsables);

        $this->data['title'] = trans('backpack::base.register'); // set the page title

        return view(backpack_view('auth.register'), $this->data)->with('qualities', $qualities);
    }
}
