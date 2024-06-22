<?php

namespace Leo\Slides\Controllers;

use Leo\Slides\Models\Slides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SlidesController 
{
    /**
     * Display a listing of the resource.
     */
    protected $model;
    public function __construct()
    {
        $this->model = Slides::class;
    }
    /**
     * Display a listing of the resource.
    */

    public function index()
    {
        $slides=Slides::select('id','slug','url','status','created_at');
        return Inertia::render('Slides/Index',['dataSlides'=>$slides]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'desktop' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'mobile' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $mobile=$request->mobile;
        $desktop= $request->desktop;
        $mobile_file_name=$mobile->getClientOriginalName();
        $mobile->storeAs('slides', $mobile_file_name);
        $desktop_file_name=$desktop->getClientOriginalName();
        $desktop->storeAs('slides', $desktop_file_name);
        $request->has('url');
        Slides::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'url'=>$request->slug,
            'desktop'=>$desktop_file_name,
            'mobile'=>$mobile_file_name,
            'created_at'=>now()
        ]);
        $slides=Slides::select('id','slug','url','status','created_at');
        return response()->json(['check'=>true,'data'=>$slides]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slides $slides,$id)
    {
        $slide=Slides::find($id)->first();
        return Inertia::render('Slides/Single',['dataSlides'=>$slide]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slides $slides)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Slides $slides,$id)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'unique:products,name',
    //         'desktop' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'mobile' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
    //     }
    //     if ($request->hasFile('desktop')) {

    //     }
    // }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'name' => 'unique:products,name,' . $id,
        'desktop' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'mobile' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
    }

    $slide = Slides::findOrFail($id);

    // Check if a new desktop image is uploaded and remove the old one
    if ($request->hasFile('desktop')) {
        // Remove old desktop image
        if ($slide->desktop) {
            Storage::delete('slides/' . $slide->desktop);
        }
        // Store new desktop image
        $desktop = $request->file('desktop');
        $desktop_file_name = $desktop->getClientOriginalName();
        $desktop->storeAs('slides', $desktop_file_name);
        $slide->desktop = $desktop_file_name;
    }

    // Check if a new mobile image is uploaded and remove the old one
    if ($request->hasFile('mobile')) {
        // Remove old mobile image
        if ($slide->mobile) {
            Storage::delete('slides/' . $slide->mobile);
        }
        // Store new mobile image
        $mobile = $request->file('mobile');
        $mobile_file_name = $mobile->getClientOriginalName();
        $mobile->storeAs('slides', $mobile_file_name);
        $slide->mobile = $mobile_file_name;
    }

    // Update other fields
    $slide->name = $request->input('name', $slide->name);
    $slide->slug = Str::slug($request->input('name', $slide->name));
    $slide->url = $request->input('url', $slide->url);
    $slide->updated_at = now();

    $slide->save();
    $slides=Slides::select('id','slug','url','status','created_at');
    return response()->json(['check' => true, 'data' => $slides]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slides $slides)
    {
        //
    }
}
