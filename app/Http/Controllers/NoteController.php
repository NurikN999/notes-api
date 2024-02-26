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
        $this->authorize('viewAny', Note::class);

        return response()->json([
            'success' => true,
            'data' => NoteResource::collection(Auth::user()->notes)
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Note::class);

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
        $this->authorize('update', $note);

        $note->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ], Response::HTTP_OK);
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Note deleted successfully'
        ], Response::HTTP_OK);
    }

}
