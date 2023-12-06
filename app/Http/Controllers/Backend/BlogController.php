<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function blogCategory()
    {
        $categories = BlogCategory::latest()->get();

        return view('backend.blog.blog_category', compact('categories'));
    }

    public function addBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Blog Category Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function updateBlogCategory(Request $request, int $id)
    {
        BlogCategory::findOrFail($id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteBlogCategory(int $id)
    {
        $blogCategory = BlogCategory::findOrFail($id);

        $blogCategory->delete();

        // invia notifica
        $notification = array(
            'message' => 'Testimonial Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.category')->with($notification);
    }
}
