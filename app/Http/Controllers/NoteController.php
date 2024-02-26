<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => NoteResource::collection(Auth::user()->notes)
        ]);
    }

    public function store(Request $request)
    {
        $note = Note::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ]);
    }

}
