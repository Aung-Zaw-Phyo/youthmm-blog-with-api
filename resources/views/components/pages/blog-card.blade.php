@props(['blog'])

<div class="col-lg-4 p-3">
    <a href="{{ route('page_viewPost', $blog->token) }}" class="text-decoration-none text-dark">
        <div class="card h-100 border border-0 shadow-sm blog-card">
            <div>
                @if ($blog->thumbnail)
                    @if (File::exists(public_path('uploads/'.$blog->thumbnail)))
                        <img class="w-100" src="{{ asset('uploads/'.$blog->thumbnail) }}" alt="">
                    @else
                        <img class="w-100" src="data:image/jpeg;base64,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" alt="">
                    @endif
                @else
                <img class="w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZXLrQ4OW7-bitD-sz8k01x6KIKFQTTmIWyw&usqp=CAU" alt="">
                @endif
            </div>
            <div class="p-3 py-4 ">
                <div class=" mb-3 ">
                    <div class="blog-title title-fs2">{{ $blog->title }}</div>
                    <div class="mt-3 d-flex justify-content-between sm-fs text-secondary">
                        <p>Author - {{ $blog->user->name }}</p>
                        <p>Published at - {{ $blog->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="blog-body body-fs">
                    {{ subStr($blog->body, 0, 130) }}
                </div>
                <div class="mt-4 sm-fs">
                    <a href="/posts?category={{ $blog->category->token }}" class="btn btn-outline-primary" style="z-index: 1000">{{ $blog->category->name }}</a>
                </div>
            </div>
        </div>
    </a>
</div>