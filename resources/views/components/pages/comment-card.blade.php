@props(['comment'])

<div class="card p-3 py-4 my-4 shadow">
    <div class="title-fs2">
        {{ $comment->user->name }}
    </div>
    <div class="sm-fs mt-1">{{ $comment->created_at->diffForHumans() }}</div>
    <div class="body-fs mt-3">
        {{ $comment->body }}
    </div>
</div>