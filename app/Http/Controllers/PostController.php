<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $games = Posts::where('user_id', Auth::id())->get();
        return response()->json($games);
    }

    public function publicPosts()
    {
        $posts = Posts::all();
        return response()->json($posts);
    }


    public function store(Request $request)
    {
        $post = Posts::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Post creado correctamente',
            'post' => $post
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $post = Posts::find($id);
        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin) {
            return response()->json(['error' => 'No tienes permisos para modificar este post.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|min:1',
            'content' => 'required|string|min:1',
        ]);

        $post->update($validated);

        return response()->json([
            'message' => 'Partida Finalizada',
            'post info' => $post
        ]);
    }

    // solo puede eliminar el post el q lo ha creado o el admin
    public function destroy($id)
    {
        $post = Posts::find($id);
        if ($post->user_id !== Auth::id() && !Auth::user()->isAdmin) {
            return response()->json(['error' => 'No tienes permiso para  eliminar este post'], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post eliminado correctamente.'
        ]);
    }
}
