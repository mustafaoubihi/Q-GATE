<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CheckList;

class CheckListController extends Controller
{

    public function index()
    {
        return CheckList::with('user')->get();
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'problem' => 'required|string',
            'zone' => 'required|string',
            'post' => 'required|string',
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

    public function update(Request $request ,$id)
    {
        // Validate the request data

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'motif' => 'nullable|string',
            'result' => 'nullable|boolean',
        ]);
        // Create a new checklist entry
        // Update the checklist fields
        CheckList::whereId($id)->update([
            'user_id' => $request->user_id,
            'motif' => $request->motif,
            'result' => $request->result,
            'isChecked' => true,
        ]);

        // Return a success response

        return response()->json(['message' => 'Checklist updated successfully.']);
        // Return a JSON response
    }
}
