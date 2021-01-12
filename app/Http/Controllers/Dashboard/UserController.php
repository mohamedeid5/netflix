<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read-users')->only('index');
        $this->middleware('permission:create-users')->only(['create', 'store']);
        $this->middleware('permission:update-users')->only(['edit', 'update']);
        $this->middleware('permission:delete-users')->only('destroy');
    }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereRoleNot('superadmin')
                        ->whenSearch(request()->search)
                        ->whenRole(request()->role_id)
                        ->with('roles')
                        ->paginate(5);

        $roles = Role::whereRoleNot('super-admin')->get();

        return view('dashboard.users.index', compact('users', 'roles'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|min:3',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|confirmed',
            'role_id'     => 'required|numeric'
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        $user = User::create($request->all());

        $user->attachRole($request->role_id);

        session()->flash('success', 'role Added successfuly');

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user  = User::find($id);
        $roles = Role::all();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'        => 'required|min:3',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'role_id'     => 'required|numeric'
        ]);

        $user->update($request->all());

        $user->syncRoles(['admin', $request->role_id]);

        session()->flash('success', 'role updated successfuly');

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        session()->flash('success', 'role deleted successfuly');
        return redirect()->route('dashboard.users.index');
    }
}
