<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Models\Category;

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
            'posts' => Post::with('postCategory', 'postAuthor')
                ->paginate(10)
                ->through(fn ($pst) => [
                    'id' => $pst->id,
                    'title' => $pst->title,
                    'slug' => $pst->slug,
                    'subtitle' => $pst->subtitle,
                    'post_content' => $pst->post_content,
                    'author' => $pst->postAuthor->only('name'),
                    'category' => $pst->postCategory ? $pst->postCategory->only('name') : null,
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
        return Inertia::render('Post/Create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'post_content' => 'required',
            'category' => 'required',
            'post_cover' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
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
        $post->post_cover = $request->file('post_cover') ? $request->file('post_cover')->store('posts', 'public') : null;
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
            'author' => Post::with( 'postAuthor'),
            'category' => Post::with('postCategory'),
            'post' =>  [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'subtitle' => $post->subtitle,
                    'post_content' => $post->post_content,
                    'author' => $post->postAuthor->only('name'),
                    'category' => $post->postCategory ? $post->postCategory->only('name') : null,
                    'post_cover' => $post->post_cover,
                    'created_at' => $post->created_at,
                ],
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
                'categories' => Category::all(),
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
        if($request->category == null) {

        }
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
