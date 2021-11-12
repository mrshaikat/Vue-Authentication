<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return send_response('Success', BlogResource::collection($blogs));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "title" => "required|min:10|max:255",
            "desc" => "required|min:20",

        ]);

        if ($validator->fails()) {

            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {
            $blogs = Blog::create([
                'title' => $request->title,
                'desc' => $request->desc,

            ]);

            return send_response('Blog create successfull', new BlogResource($blogs));
        } catch (Exception $e) {

            return send_error('Something wrong !', $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);

        if ($blog) {
            return send_response('Success', new BlogResource($blog));
        } else {
            return send_error('Data not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {

        $validator = Validator::make($request->all(), [
            "title" => "required|min:10|max:255",
            "desc" => "required|min:20",
        ]);

        if ($validator->fails()) {

            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {

            $blog->title = $request->title;
            $blog->desc = $request->desc;
            $blog->save();

            return send_response('Blog Update successfull', new BlogResource($blog));
        } catch (Exception $e) {

            return send_error('Something wrong !', $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::find($id);
            if ($blog) {
                $blog->delete();
            }
            return send_response('Blog Delete Success', []);
        } catch (Exception $e) {

            return send_error('Something wrong !', $e->getCode());
        }
    }
}