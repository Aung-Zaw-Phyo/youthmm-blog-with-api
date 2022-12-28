<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YOUTH.MM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/7c0ec42130.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/css/app.css">
</head>
<body>

    <div class="sidebar p-3 bg-light shadow">
        <div class="d-flex justify-content-center">
            {{-- <img class="w-100" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQT38V_w6LkpOF37Mts3QblVvdO5pgSkNujhA&usqp=CAU" alt=""> --}}
            <span class="logo-1">YOUTH </span> <span class="logo-2">MM</span>
        </div>
        <div class="p-2 logoContainer">
            <a class="text-decoration-none text-light fw-bold" href="{{route('blogs')}}"><i class="fa-solid fa-house-chimney"></i> Dashboard</a>
        </div>

        <ul class="list-unstyled p-2 mt-3">
            <li class="linkHeader mb-2">
                Blogs Management
            </li>
            <li class="linkContainer">
                <a href="{{route('blogs')}}" class="link"><i class="fa-solid fa-list me-2"></i>Blogs</a>
            </li>
            <li class="linkContainer">
                <a href="{{route('addBlog')}}" class="link"><i class="fa-solid fa-list me-2"></i>Entry</a>
            </li>
{{--            <div class="accordion accordion-flush" id="accordionFlushExample">--}}
{{--                <div class="accordion-item bg-transparent">--}}
{{--                  <h2 class="accordion-header " id="flush-headingOne">--}}
{{--                    <button class="accordion-button bg-transparent ps-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#products" aria-expanded="false" aria-controls="products">--}}
{{--                        Blogs--}}
{{--                    </button>--}}
{{--                  </h2>--}}
{{--                  <div id="products" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">--}}
{{--                    <div class="accordion-body p-0">--}}
{{--                        <ul class="list-unstyled">--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </ul>

        <ul class="list-unstyled p-2 mt-3">
            <li class="linkHeader mb-2">
                Category Management
            </li>
            <li class="linkContainer">
                <a href="{{route('categories')}}" class="link"><i class="fa-solid fa-list me-2"></i>Categories</a>
            </li>
            <li class="linkContainer">
                <a href="{{route('addCategory')}}" class="link"><i class="fa-solid fa-list me-2"></i>Entry</a>
            </li>
{{--            <div class="accordion accordion-flush" id="accordionFlushExample">--}}
{{--                <div class="accordion-item bg-transparent">--}}
{{--                  <h2 class="accordion-header " id="flush-headingOne">--}}
{{--                    <button class="accordion-button bg-transparent ps-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#category" aria-expanded="false" aria-controls="category">--}}
{{--                        Categories--}}
{{--                    </button>--}}
{{--                  </h2>--}}
{{--                  <div id="category" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">--}}
{{--                    <div class="accordion-body p-0">--}}
{{--                        <ul class="list-unstyled">--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </ul>

        <ul class="list-unstyled p-2 mt-3">
            <li class="linkHeader mb-2">
                User Management
            </li>
            <li class="linkContainer">
                <a href="{{route('users')}}" class="link"><i class="fa-solid fa-users me-2"></i>Users</a>
            </li>
{{--            <div class="accordion accordion-flush" id="accordionFlushExample">--}}
{{--                <div class="accordion-item bg-transparent">--}}
{{--                  <h2 class="accordion-header " id="flush-headingOne">--}}
{{--                    <button class="accordion-button bg-transparent ps-0 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#users" aria-expanded="false" aria-controls="users">--}}
{{--                        Users--}}
{{--                    </button>--}}
{{--                  </h2>--}}
{{--                  <div id="users" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">--}}
{{--                    <div class="accordion-body p-0">--}}
{{--                        <ul class="list-unstyled">--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                            <li class="py-2"><a href="" class=" link">Item 1</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </ul>

        <ul class="list-unstyled p-2 mt-3">
            <li class="linkHeader mb-2">
                Subscriber Management
            </li>
            <li class="linkContainer">
                <a href="{{route('subscribers')}}" class="link"><i class="fa-solid fa-users me-2"></i>Subscribers</a>
            </li>
        </ul>

    </div>


    <div class="main">
        <div class="p-3">
            <nav class="d-flex justify-content-between">
                <div class="menuContainer">
                    <span class="menu pt-2" ><i class="fa-solid fa-bars fs-4"></i></span>
                </div>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><div class="dropdown-item" >username: johndoe</div></li>
                        <li><div class="dropdown-item" >email: johndoe@gmail.com</div></li>
                        <li>
                            <form action="#" method="POST">
                                <button class="btn btn-link">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="body pt-5">

{{--                {{ $slot }}--}}
                @yield('content')

            </div>
        </div>
        <footer class="shadow-lg">
            Copyright © 2022 YOUTH.MM. All rights reserved.
        </footer>
    </div>

    <script src="/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    @yield('script')

</body>
</html>

