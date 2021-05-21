<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::get()->load('roles');
       // return $users->paginate(10);
       return User::orderBy('created_at', 'desc')->paginate(10);
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

        $data = $request->input('user');
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt('123456');

        $user->email_verified_at = now();
        $user->department_id = $data['department_id'];
        $role  = Role::where('name', $data['role'])->first();

        $user->account_type = $data['account_type'];
        $user->save();
        $user->roles()->attach($role);
        return response([
            'user' => $user
        ], 200);
/*
        $this->validate($request, [
            'name' => 'required|min:5',
            'email' => 'required|email',
            'role' => 'required',
            'account_type'=> 'required'
        ]);
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt('123456'),
            'email_verified_at' => now(),
            'department_id' => 1,
            'account_type' => $request->get('account_type'),
        ]);
        $role  = Role::where('name', $request->get['role'])->first();
        $user->roles()->attach($role);
        return response([
            'user' => $user
        ], 200); */
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
        //
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
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response([
            'user' => $user
        ], 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response([
            'result' => 'success'
        ], 200);
    }

    public function userSearch(Request $request)
    {
        $search = $request->get('q');
        return User::where('name', 'like', '%'.$search.'%')
                ->orwhere("email", 'like', '%'.$search.'%')
                ->orwhere("department_id", 'like', '%'.$search.'%')
                ->orwhere("account_type", 'like', '%'.$search.'%')
                ->get();
    }
}
