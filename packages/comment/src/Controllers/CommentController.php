<?php

namespace khanhduy\Comment\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use khanhduy\Comment\Models\Comment;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::with('product', 'customer', 'user',  'service', 'parent.customer')->get();
        return Inertia::render('Comments/Index', ['comments' => $comments]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_parent' => 'required',
            'id_product' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }

        $req = $request->all();
        $req['id_user'] = $request->session()->get('user')->id;
        $comment = Comment::create($req);
        if ($comment) {
            $data = Comment::with('product', 'customer', 'user',  'service', 'parent')->get();
            return response()->json(['check' => true, 'msg' => 'Thêm thành công', 'data' => $data]);
        }
    }

    public function addComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_product' => 'required',
            'comment' => 'required',
            'id_parent' => 'nullable|exists:comment,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }

        $req = $request->all();
        $req['id_customer'] = $request->user()->id;

        $comment = Comment::create($req);

        if ($comment) {
            $data = Comment::with('product', 'customer', 'user', 'service', 'parent')->where('id_product', $request->id_product)->get();
            return response()->json(['check' => true, 'msg' => 'Thêm thành công', 'data' => $data]);
        }
        return response()->json(['check' => false, 'msg' => 'Thêm thất bại']);
    }

    // public function show($id)
    // {
    //     $comment = Comment::find($id);
    //     return response()->json(['check' => true, 'data' => $comment]);
    // }

    // public function edit($id)
    // {
    //     $comment = Comment::find($id);
    //     return response()->json(['check' => true, 'data' => $comment]);
    // }

    public function update(Request $request, $id)
    {
        $req = $request->all();
        $comment = Comment::findOrFail($id)->update($req);
        if ($comment) {
            $data = Comment::with('product', 'customer', 'user',  'service', 'parent')->get();
            return response()->json(['check' => true, 'msg' => 'Sửa thành công', 'data' => $data]);
        }
    }

    public function updatedComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }

        $comment = Comment::find($id);

        if (!$comment || $comment->id_customer !== $request->user()->id) {
            return response()->json(['check' => false, 'msg' => 'Bạn không có quyền sửa bình luận này']);
        }


        $comment->update($request->all());

        $data = Comment::with('product', 'customer', 'user', 'service', 'parent')->get();
        return response()->json(['check' => true, 'msg' => 'Sửa thành công', 'data' => $data]);
    }


    public function destroy($id)
    {
        $comment = Comment::find($id)->delete();
        if ($comment) {
            $data = Comment::with('product', 'customer', 'user',  'service', 'parent')->get();
            return response()->json(['check' => true, 'msg' => 'Sửa thành công', 'data' => $data]);
        }
        return response()->json(['check' => true]);
    }

    public function deleteComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment || $comment->id_customer !== $request->user()->id) {
            return response()->json(['check' => false, 'msg' => 'Bạn không có quyền xóa bình luận này']);
        }

        $comment->delete();

        $data = Comment::with('product', 'customer', 'user', 'service', 'parent')->get();
        return response()->json(['check' => true, 'msg' => 'Xóa thành công', 'data' => $data]);
    }
}
