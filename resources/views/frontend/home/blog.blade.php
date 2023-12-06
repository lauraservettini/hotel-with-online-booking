@php
    $posts = App\Models\BlogPost::latest()->limit(3)->get();
@endphp
<div class="blog-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">BLOGS</span>
            <h2>Our Latest Blogs to the Intranational Journal at a Glance</h2>
        </div>
        <div class="row pt-45">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item">
                    <a href="{{ url('blog/details/' . $post->post_slug) }}">
                        <img src="{{ asset($post->post_image)}}" alt="{{ $post->post_title}}">
                    </a>
                    <div class="content">
                        <ul>
                            <li>{{ $post->created_at->format('d-m-Y') }}</li>
                            <li><i class='bx bx-user'></i>29K</li>
                            <li><i class='bx bx-message-alt-dots'></i>15K</li>
                        </ul>
                        <h3>
                            <a href="{{ url('blog/details/' . $post->post_slug) }} "> $post->post_title  }}</a>
                        </h3>
                        <p> {{ $post->short_descr }}</p>
                        <a href="{{ url('blog/details/' . $post->id . '/' . $post->post_slug) }}" class="read-btn">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>