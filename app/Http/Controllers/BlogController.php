<?php

namespace App\Http\Controllers;

use App\DataTables\BlogCategoryDataTable;
use App\DataTables\BlogCommentDataTable;
use App\DataTables\BlogDataTable;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable )
    {
        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = BlogCategory::all();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {

        $imagePath = $this->uploadImage($request, 'image');
        Blog::create([
            'user_id' => auth()->user()->id,
            'image' => $imagePath,
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr()->success('Created Successfully');
        return redirect(route('admin.blog.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $categories = BlogCategory::all();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $blog = Blog::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $blog->update([
            'user_id' => auth()->user()->id,
            'image' => !empty($imagePath) ? $imagePath : $request->old_image,
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr()->success('Updated Successfully');
        return redirect(route('admin.blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $this->removeImage($blog->image);
            $blog->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }

    public function blogComment(BlogCommentDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-comments.index');
    }

    public function commentStatusUpdate(string $id)
    {
        $comment = BlogComment::findOrFail($id);
        $comment->status = !$comment->status;
        $comment->save();
        toastr()->success('Status Updated Successfully');
        return redirect(route('admin.blog.comments.index'));
    }

    public function commentDestroy(string $id)
    {
        try {
            $comment = BlogComment::findOrFail($id);
            $comment->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
