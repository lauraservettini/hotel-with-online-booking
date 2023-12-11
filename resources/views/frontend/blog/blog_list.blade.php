 @extends('frontend.main_master')

@section('master')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Blog</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Blog</li>
            </ul>
            <h3>Blog List</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Blog Style Area -->
<div class="blog-style-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        @foreach($posts as $post)
                            <div class="col-lg-12">
                                <div class="blog-card">
                                    <div class="row align-items-center">
                                        <div class="col-lg-5 col-md-4 p-0">
                                            <div class="blog-img">
                                                <a href="{{ url('blog/details/' . $post->id . '/' . $post->post_slug) }}">
                                                    <img src="{{ asset($post->post_image) }}" alt="{{ $post->post_title}}">
                                                </a>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-7 col-md-8 p-0">
                                            <div class="blog-content">
                                                <span>{{ $post->created_at->format('d-m-Y') }}</span>
                                                <h3>
                                                    <a href="{{ url('blog/details/' . $post->id . '/' . $post->post_slug) }}">{{ $post->post_title}}</a>
                                                </h3>
                                                <p>{{ $post->short_descr }}</p>
                                                <a href="{{ url('blog/details/' . $post->id . '/' . $post->post_slug) }}" class="read-btn">
                                                    Read More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="col-lg-12 col-md-12">
                            <div class="pagination-area">

                                {{ $posts->links('vendor.pagination.custom') }}

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="side-bar-wrap">
                            <div class="services-bar-widget">
                                <h3 class="title">Blog Category</h3>
                                <div class="side-bar-categories">
                                    <ul>
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ url('blog/category/list/' . $category->id) }}">{{ $category->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="side-bar-widget">
                                <h3 class="title">Recent Posts</h3>
                                <div class="widget-popular-post">
                                    @foreach($blogs as $blog)
                                        <article class="item">
                                            <a href="{{ url('blog/details/' . $blog->id . '/' . $blog->post_slug) }}" class="thumb">
                                                <img src="{{ url($blog->post_image) }}" alt="Images" style="width: 80px; height: 80px">
                                            </a>
                                            <div class="info">
                                                <h4 class="title-text">
                                                    <a href="{{ url('blog/details/' . $blog->id . '/' . $blog->post_slug) }}">{{ $blog->post_title }}</a>
                                                </h4>
                                                <ul>
                                                    <li>
                                                        <i class="bx bx-user"></i>
                                                        29K
                                                    </li>
                                                    <li>
                                                        <i class="bx bx-message-square-detail"></i>
                                                        15K
                                                    </li>
                                                </ul>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>

                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Blog Style Area End -->

@endsection