<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => NoteResource::collection(Auth::user()->notes)
        ], Response::HTTP_OK);
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
        ], Response::HTTP_CREATED);
    }

    public function show(Note $note)
    {
        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ], Response::HTTP_OK);
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $note->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ], Response::HTTP_OK);
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ], Response::HTTP_OK);
    }

}
