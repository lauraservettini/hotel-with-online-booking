<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

    public function blogPosts()
    {
        $posts = BlogPost::latest()->get();

        return view('backend.blog.blog_posts', compact('posts'));
    }

    public function addBlogPost()
    {
        $categories = BlogCategory::latest()->get();
        return view('backend.blog.add_blog_post', compact('categories'));
    }

    public function storeBlogPost(Request $request)
    {
        //Validation
        $request->validate([
            "category_id" => "required",
            "post_title" => "required",
            "short_descr" => "required",
            "long_descr" => "required",
            "post_image" => "required"
        ]);

        $image = $request->file('post_image');
        if ($image) {
            // Crea il nome per l'immagine
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // resize image
            Image::make($image)->resize(550, 370)->save('upload/blog/posts/' . $name_gen);
            $save_url = 'upload/blog/posts/' . $name_gen;

            // salva i dati nel database con l'immagine
            BlogPost::insert([
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_image' => $save_url,
                'short_descr' => $request->short_descr,
                'long_descr' => $request->long_descr,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'created_at' => Carbon::now()
            ]);
        } else {
            // salva i dati nel database senza immagine
            BlogPost::insert([
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'short_descr' => $request->short_descr,
                'long_descr' => $request->long_descr,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'created_at' => Carbon::now()
            ]);
        }

        // invia notifica
        $notification = array(
            'message' => 'Post Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.posts')->with($notification);
    }

    public function editBlogPost(int $id)
    {
        $categories = BlogCategory::latest()->get();
        $post = BlogPost::find($id);

        return view('backend.blog.update_post', compact('post', 'categories'));
    }

    public function updateBlogPost(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "category_id" => "required",
            "post_title" => "required",
            "short_descr" => "required",
            "long_descr" => "required"
        ]);

        $post = BlogPost::findOrFail($id);

        $image = $request->file('post_image');
        if ($image) {
            // Crea il nome per l'immagine
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $oldImage = $post->post_image;
            // resize image
            Image::make($image)->resize(550, 370)->save('upload/blog/posts/' . $name_gen);
            $save_url = 'upload/blog/posts/' . $name_gen;

            // salva i dati nel database con l'immagine
            $post->update([
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_image' => $save_url,
                'short_descr' => $request->short_descr,
                'long_descr' => $request->long_descr,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'created_at' => Carbon::now()
            ]);

            unlink($oldImage);
        } else {
            // salva i dati nel database senza immagine
            $post->update([
                'category_id' => $request->category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'short_descr' => $request->short_descr,
                'long_descr' => $request->long_descr,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'created_at' => Carbon::now()
            ]);
        }

        // invia notifica
        $notification = array(
            'message' => 'Post Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.posts')->with($notification);
    }

    public function deleteBlogPost(int $id)
    {
        $post = BlogPost::findOrFail($id);

        unlink($post->post_image);

        $post->delete();

        // invia notifica
        $notification = array(
            'message' => 'Post Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('blog.posts')->with($notification);
    }
}
