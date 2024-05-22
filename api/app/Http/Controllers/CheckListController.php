<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;

class CheckListController extends Controller
{

    public function index()
    {
        return CheckList::all();
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'problem' => 'required|string',
            'zone' => 'required|string',
            'post' => 'required|string',
            'isChecked' => 'required|boolean',
            'nbProblems' => 'required|integer',
            'valideImgUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'notValideImgUrl' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the uploaded files and get their paths
        $valideImgPath = $request->file('valideImgUrl')->store('uploads', 'public');
        $notValideImgPath = $request->file('notValideImgUrl')->store('uploads', 'public');

        // Create a new checklist entry
        $checkList = CheckList::create([
            'problem' => $request->problem,
            'zone' => $request->zone,
            'post' => $request->post,
            'boolean' => $request->boolean,
            'nbProblems' => $request->nbProblems,
            'valideImgUrl' => $valideImgPath,
            'notValideImgUrl' => $notValideImgPath,
        ]);

        // Return a JSON response
        return response()->json($checkList, 201);
    }
}
