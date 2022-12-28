@extends('layouts/pages_layout')

@section('content')

    <div class="col-12 col-lg-10 mx-auto">

        <div class="p-2 text-center my-5">
            <span class="hero-logo-1">YOUTH</span> <span class="hero-logo-2">MM</span> <span class="fs-1 fw-bold ms-3 title-fs">Blogs & News</span>
        </div>

        <div class="p-2 col-lg-10 mx-auto">
            <form action="">
                <div class="input-group body-fs">
                    <input type="hidden" name="category" value="{{ request('category') ? request('category') : '' }}">
                    <input type="text" name="search" value="{{ request('search') ? request('search') : '' }}" class="form-control form-control-lg" placeholder="Search for blogs & news">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>
            <div class="d-flex justify-content-center flex-wrap mt-3">
                <a href="{{ route('page_posts') }}" class="btn btn-outline-primary m-3">All</a>
                @foreach ($categories as $category)
                <a href="/posts?category={{ $category->token }}" class="btn {{ request('category') && request('category') == $category->token ? 'btn-primary' : 'btn-outline-primary' }} m-3">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>


        @if ($blogs->count() > 0)
            <div class="latest-blog-section p-4 my-5">
                <div class="row">
                    @foreach($blogs as $blog)
                        <x-pages.blog-card :blog='$blog' />
                    @endforeach
                    <div class="py-5 pb-3">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-8 col-lg-6 col-xl-5 mx-auto py-5">
                <img class="w-100" src="https://creativecodermm.com/build/assets/notfounddata.cd41d54a.jpg" alt="">
                <div class="body-fs text-secondary text-center">
                    No Results Found.
                </div>
            </div>
        @endif


    </div>




@endsection


