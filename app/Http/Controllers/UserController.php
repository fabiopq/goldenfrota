<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\ValidCurrentPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'name' => 'Nome',
        'username' => 'Usuário',
        'email' => 'E-mail',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarUser()) {
            if (isset($request->searchField)) {
                $users = DB::table('users')
                    ->where('name', 'like', '%' . $request->searchField . '%')
                    ->orWhere('username', 'like', '%' . $request->searchField . '%')
                    ->orWhere('email', 'like', '%' . $request->searchField . '%')
                    ->paginate();
            } else {
                $users = User::paginate();
            }

            return View('user.index')->withUsers($users)->withFields($this->fields);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->canCadastrarUser()) {
            return View('user.create');
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->canCadastrarUser()) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'username' => 'required|string|min:4|max:12|unique:users',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]);

            try {
                $user = new User();
                $user->name = $request->name;
                $user->username = $request->username;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);

                if ($user->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.user'),
                        'name' => $user->name
                    ]));
                    return redirect()->action('UserController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->canAlterarUser()) {
            return View('user.edit')->withUser($user);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->canAlterarUser()) {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'username' => 'nullable|string|min:4|max:12|unique:users,id,' . $user->id,
                'email' => 'required|string|email|max:255|unique:users,id,' . $user->id,
                'password' => 'nullable|min:6|confirmed',
            ]);

            try {
                $user = User::find($user->id);
                $user->name = $request->name;
                if (!is_null($request->password)) {
                    $user->password = bcrypt($request->password);
                }
                if ($user->email != $request->email) {
                    $user->email = $request->email;
                }
                $user->ativo = $request->ativo;

                if ($user->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.user'),
                        'name' => $user->name
                    ]));
                    return redirect()->action('UserController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->canExcluirUser()) {
            try {
                $user = User::find($user->id);
                if ($user->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.user'),
                        'name' => $user->name
                    ]));

                    return redirect()->action('UserController@index');
                }
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        Session::flash('error', __('messages.fk_exception'));
                        break;
                    default:
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                        break;
                }
                return redirect()->action('UserController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function profile()
    {
        return view('user.profile')->withUser(Auth::user());
    }

    public function showChangePassword()
    {
        return view('user.change-password')->withUser(Auth::user());
    }

    public function changePassword(Request $request, User $user)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'current_password' => ['required', new ValidCurrentPassword($user->password)]
        ]);

        try {
            $user->password = bcrypt($request->password);

            if ($user->save()) {
                Session::flash('success', __('messages.password_change_success', [
                    'user' => $user->name
                ]));
                return redirect()->action('UserController@profile');
            }
        } catch (\Exception $e) {
            Session::flash('error', __('messages.exception', [
                'exception' => $e->getMessage()
            ]));
            return redirect()->back();
        }
    }

    public function apiUsers(Request $request)

    {

        return response()->json(DB::table('users')
            ->select('users.*')
            ->orderBy('users.password', 'desc')

            ->get());
    }

    public function apiUser($username)

    {

        return response()->json(DB::table('users')
            ->select('users.id', 'users.username', 'permissions.name as permissao')
            ->leftJoin('role_user', 'role_user.user_id', 'users.id')
            ->leftJoin('permission_role', 'permission_role.role_id', 'role_user.id')
            ->leftJoin('permissions', 'permission_role.permission_id', 'permissions.id')
            ->where('users.name', $username)
            //->orderBy('users.id')
            ->get());
    }
}
