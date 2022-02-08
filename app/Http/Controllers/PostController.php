<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Post/Index', [
            'posts' => Post::paginate(10)
                ->through(fn ($pst) => [
                    'id' => $pst->id,
                    'title' => $pst->title,
                    'slug' => $pst->slug,
                    'subtitle' => $pst->subtitle,
                    'post_content' => $pst->post_content,
                    'author' => $pst->author,
                    'category' => $pst->category,
                    'post_cover' => $pst->post_cover,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'post_content' => 'required',
        ]);

        if(!$validated) {
            return Redirect::route('post.index');
        }

        $post = New Post();
        $slug = $this->setSlug($request->title);

        $post->title = $request->title;
        $post->slug = $slug;
        $post->subtitle = $request->subtitle;
        $post->post_content = $request->post_content;
        $post->author = $request->author;
        $post->category = $request->category;
        $post->post_cover = $request->post_cover;
        $post->save();

        return Redirect::route('post.index')->with(['toast' => ['message' => "Post ".$request->title." cadastrado!"]]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Post/Show',[
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->id) {
            return Inertia::render('Post/Edit', [
                'post' => Post::find($post->id),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if($post->id) {
            Post::find($post->id)->update($request->all());
        }
        return Redirect::route('post.index')->with(['toast' => ['message' => "Post ".$post->title." atualizado com sucesso!"]]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return Redirect::route('post.index')->with(['toast' => ['message' => "Post excluído com sucesso!"]]);
    }

    private function setSlug($post) {
        $titleSlug = Str::slug($post);

        $query = Post::all();

        $t = 0;
        foreach ($query as $post) {
            if (Str::slug($post->title) === $titleSlug) {
                $t++;
            }
        }

        if ($t > 0) {
            $titleSlug = $titleSlug . '-' . $t;
        }

        return $titleSlug;
    }
}
