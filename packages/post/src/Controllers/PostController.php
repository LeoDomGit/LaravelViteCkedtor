<?php

namespace Leo\Post\Controllers;

use App\Http\Controllers\Controller;
use Leo\Post\Models\Post;
use Leo\Post\Models\PostCate;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Leo\Products\Models\Products;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('cates')->get();
        $cates = PostCate::active()->select('id','name')->get();
        $products = Products::active()->select('id','name')->get();
        return Inertia::render('Posts/Index', ['posts' => $posts,'cates'=>$cates,'products'=>$products]);
    }

    public function create()
    {
        $postCates = PostCate::active()->get();
        return Inertia::render('Posts/Create', ['postCates' => $postCates]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title',
            'summary' => 'required',
            'content' => 'required',
            'id_collection' => 'required|exists:post_cates,id',
        ], [
            'title.required' => 'Chưa nhận được tiêu đề bài viết',
            'title.unique' => 'Tiêu đề bài viết bị trùng',
            'summary.required' => 'Chưa nhận được tóm tắt bài viết',
            'content.required' => 'Chưa nhận được nội dung bài viết',
            'id_collection.required' => 'Chưa nhận được loại bài viết',
            'id_collection.exists' => 'Loại bài viết không tồn tại',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        Post::create($data);

        $posts = Post::with('cates')->get();
        return response()->json(['check' => true, 'data' => $posts]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $postCates = PostCate::all();
        return Inertia::render('Posts/Edit', ['post' => $post, 'postCates' => $postCates]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title,' . $post->id,
            'summary' => 'required',
            'content' => 'required',
            'id_collection' => 'required|exists:post_cates,id',
        ], [
            'title.required' => 'Chưa nhận được tiêu đề bài viết',
            'title.unique' => 'Tiêu đề bài viết bị trùng',
            'summary.required' => 'Chưa nhận được tóm tắt bài viết',
            'content.required' => 'Chưa nhận được nội dung bài viết',
            'id_collection.required' => 'Chưa nhận được loại bài viết',
            'id_collection.exists' => 'Loại bài viết không tồn tại',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }

        $data = $request->all();
        if ($request->has('title')) {
            $data['slug'] = Str::slug($request->title);
        }

        $post->update($data);

        $posts = Post::with('cates')->get();
        return response()->json(['check' => true, 'data' => $posts]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        $posts = Post::with('cates')->get();
        return response()->json(['check' => true, 'data' => $posts]);
    }
}

