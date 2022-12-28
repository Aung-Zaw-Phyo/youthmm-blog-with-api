@extends('layouts.admin_layout')

@section('content')
    <div class="p-3">
        <div class="col-lg-10 col-xl-7 mx-auto">
            @if ($blog->thumbnail)
            <div>
                <img class="w-100" src="{{ asset("uploads/$blog->thumbnail") }}" style="border-radius: 10px;" alt="">
            </div>
            @endif
            <div class="my-4">
                <h4 class="" style="font-family: 'Abyssinica SIL', serif">{{ $blog->title }}</h3>
                <div class="d-flex justify-content-between mt-3 text-secondary">
                    <div class="fs"> {{ $blog->user->name }} </div>
                    <div class="fs"> {{ $blog->created_at->diffForHumans() }} </div>
                </div>
            </div>
            <div class="fs" style="text-align: justify">
                {{ $blog->body }}
            </div>
            
            @if ($blog->comments()->count() > 0)
            <div class="my-5">
                <div class="fs h3 mb-4"> Comments ({{ $blog->comments()->count() }}) </div>
                <?php $comments = $blog->comments()->latest()->paginate(2) ?>
                @foreach ( $comments as $comment )
                    <div class="card shadow-sm p-2 py-3 mb-3" style="border-radius: 8px;">
                        <div class="mb-3">
                            <div class="fs">{{ $comment->user->name }}</div>
                            <div class="text-secondary fs">{{  $comment->created_at->diffForHumans() }}</div>
                        </div>
                        <div>
                            {{ $blog->body }}
                        </div>
                    </div>
                @endforeach ()
                <div class="mt-5">
                    {{ $comments->links() }}
                </div>
            </div>
            @endif

        </div>
    </div>

@endsection

@section('script')
    
@endsection


