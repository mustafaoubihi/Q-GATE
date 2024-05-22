<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'employerBadge' => 'required|unique:users',
            'firstName' => 'required',
            'lastName' => 'required',
            'CIN' => 'required',
            'role' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = $request->file('image')->store('uploads', 'public');

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password,
            'employerBadge' => $request->employerBadge,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'CIN' => $request->CIN,
            'role' => $request->role,
            'image' => $image
        ]);

        return response()->json($user, 201);
    }
}
