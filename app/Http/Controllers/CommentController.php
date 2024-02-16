<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')
            ->except(['index', 'show']);
        $this->authorizeResource(Comment::class, 'comment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CommentResource::collection(
            Comment::paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = Comment::create([
            ...$request->validate([
                'company_id' => 'required|exists:companies,id',
                'interview_review' => 'required|string',
                'rating' => 'required|integer|between:1,10',
            ]),
            'user_id' => $request->user()->id,
        ]);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->validate([
            'interview_review' => 'sometimes|required|string',
            'rating' => 'sometimes|required|integer|between:1,10',
        ]));

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response(status: 204);
    }
}
