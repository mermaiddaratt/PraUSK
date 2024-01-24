<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.add-user');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users = User::create($request->all());
        if($users){
            return redirect('home')->with("status","Success Add User");
        }
        return redirect()->back()->with("status","Failed Add User");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        if($user){
            return redirect('home')->with("status","Success Update User");
        }
        return redirect()->back()->with("status","Failed Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        if($user){
            return redirect('home')->with("status","Success Delete User");
        }
        return redirect()->back()->with("status","Failed to Delete User");
    }
}
