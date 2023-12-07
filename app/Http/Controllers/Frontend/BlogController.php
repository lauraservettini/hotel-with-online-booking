<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Comment;

class BlogController extends Controller
{
    public function detailsBlogPost(int $id, string $slug)
    {
        $post = BlogPost::find($id);
        $categories = BlogCategory::latest()->get();
        $blogs = BlogPost::latest()->limit(3)->get();
        $comments = Comment::where('post_id', $id)->where('status', 1)->get();

        return view('frontend.blog.post_details', compact('post', 'categories', 'blogs', 'comments'));
    }

    public function categoryBlogPost(int $id)
    {
        $posts = BlogPost::where('category_id', $id)->get();

        $nameCategory = BlogCategory::find($id);

        $categories = BlogCategory::latest()->get();

        $blogs = BlogPost::latest()->limit(3)->get();


        return view('frontend.blog.category', compact('posts', 'categories', 'blogs', 'nameCategory'));
    }

    public function listBlogPost()
    {
        $categories = BlogCategory::latest()->get();
        $posts = BlogPost::latest()->paginate(3);
        $blogs = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_list', compact('posts', 'categories', 'blogs'));
    }
}
