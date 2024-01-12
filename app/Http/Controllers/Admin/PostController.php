<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view ('admin.posts.index', compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        $formData = $request->validated();
        // creo lo slug 
        $slug = Str::slug($formData['title'], '-');
        // aggiungo slug al formdata
        $formData['slug'] = $slug;
        // prendiamo l'id dell'utente che sta facendo l'operazione
        $userId = auth()->id();
        // aggiungiamo l'id dell'utente
        $formData['userId'] = $userId;
        $post = Post::create($formData);
        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $formData = $request->validated();
        // creo lo slug 
        $slug = Str::slug($formData['title'], '-');
        // aggiungo slug al formdata
        $formData['slug'] = $slug;
        // prendiamo l'id dell'utente che sta facendo l'operazione
        $formData['user_id'] = $post->user_id();
        // aggiungiamo l'id dell'utente
        $post->update($formData);
        $post = Post::create($formData);
        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();
        return to_route('admin.posts.index')->with('message', 'Post $post->title Eliminato Correttamente');
    }
}
