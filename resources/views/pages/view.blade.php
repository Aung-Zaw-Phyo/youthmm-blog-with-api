@extends('layouts.pages_layout')

@section('content')

<div class="col-12 col-lg-10 mx-auto py-5">
        <div class="col-12 col-lg-8 col-xl-7 mx-auto p-3">

            <div>
                @if ($blog->thumbnail)
                <img class="w-100" src="{{ asset('uploads/'.$blog->thumbnail) }}" alt="">
                @else
                <img class="w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSZXLrQ4OW7-bitD-sz8k01x6KIKFQTTmIWyw&usqp=CAU" alt="">
                @endif
            </div>
            <div class=" py-4 ">
                <div class=" mb-3 ">
                    <div class="blog-title title-fs2">{{ $blog->title }}</div>
                    <div class="mt-3 d-flex justify-content-between sm-fs text-secondary">
                        <p>Author - {{ $blog->user->name }}</p>
                        <p>Published at - {{ $blog->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="blog-body body-fs">
                    {{ $blog->body }}
                </div>
            </div>

            <div class="comment-section mt-3">
                @auth
                <form class="body-fs" action="{{ route('comment', $blog->token) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="body" class="form-label title-fs mb-3">Participate in our discusion!</label>
                        <textarea class="form-control" name="body" id="body" cols="30" rows="7" placeholder="Enter your comment"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                @else
                <div class="title-fs">Please <a href="/login">login</a> to participate in this discussion!</div>
                @endauth

                <div class="mt-5">
                    <div class="title-fs">
                        Comments ({{ $blog->comments->count() }})
                    </div>
                    <div class="mt-3">
                        @foreach ($blog->comments()->latest()->paginate(3) as $comment)
                            <x-pages.comment-card :comment='$comment' />
                        @endforeach
                        <div class="mt-5">
                            {{ $blog->comments()->latest()->paginate(3)->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>

@endsection

@section('script')



@endsection