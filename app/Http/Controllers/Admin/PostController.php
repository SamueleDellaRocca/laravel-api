<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\User;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $validators = [
        'title'     => 'required|max:100',
        'content'   => 'required'
    ];

    private function getValidators($model) {
        return [
            'title'     => 'required|max:100',
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($model),
                'max:100'
            ],
            'tags' => 'exists:App\Tag,id',
            'content'   => 'required',
            'category_id'  => 'required|exists:App\Category,id',
        ];
    }

    public function myindex(Request $request)
    {
        $posts = Post::where('user_id', Auth::user()->id)->paginate(25);
        // $posts = Post::where('id', '>', 0);

        if ($request->s) {
            $posts->where('title', 'LIKE', "%$request->s%");
        }
        if ($request->category) {
            $posts->where('category_id', $request->category);
        }
        if ($request->author) {
            $posts->where('user_id', $request->author);
        }

        $categories = Category::all();
        $users = User::all();

        $data = [
            'posts'         => $posts,
            'categories'    => $categories,
            'users'         => $users,
            'request'       => $request
        ];

        return view('admin.posts.index', $data);
    }


    public function index(Request $request)
    {
        $posts = Post::whereRaw('1 = 1');
        
        if ($request->s) {
            $posts->where(function($query) use ($request) { // per aggiungere le parentesi nell'SQL
                $query->where('title', 'LIKE', "%$request->s%")
                    ->orWhere('content', 'LIKE', "%$request->s%");
            });
        }
        if ($request->category) {
            $posts->where('category_id', $request->category);
        }
        if ($request->author) {
            $posts->where('user_id', $request->author);
        }
        
        $posts = $posts->paginate(25);
        
        $categories = Category::all();
        $users = User::all();

        $data = [
            'posts'         => $posts,
            'categories'    => $categories,
            'users'         => $users,
            'request'       => $request
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.create', [
            'categories' => $categories,
            'tags' => $tags,
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
        $request->validate($this->getValidators(null));

        $data = $request->all();

        $img_path = Storage::put('uploads', $data['post_image']);


        $formData = [
            'user_id' => Auth::user()->id,
            'post_image' => $img_path,
        ] + $data;
        
        $post = Post::create($formData);
        $post->tags()->attach($formData['tags']);

        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {   
        $categories = Category::all();
        $tags = Tag::all();

        if (Auth::user()->id !== $post->user_id) abort(403);

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->getValidators($post));
        $formData = $request->all();

        if (array_key_exists('post_image', $formData)) {
            Storage::delete($post, $post->post_image);
            $img_path = Storage::put('uploads', $formData['post_image']);

            $formData = [
                'post_image' => $img_path,
            ] + $formData;
        }

        if (array_key_exists('tags', $formData)) {
            $post->tags()->sync($formData['tags']);
        }
        $post->update($formData);
        return redirect()->route('admin.posts.show', $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->id !== $post->user_id) abort(403);

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
