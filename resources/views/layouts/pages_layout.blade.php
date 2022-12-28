<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/7c0ec42130.js" crossorigin="anonymous"></script>
    <title class="title-fs">YOUTH.MM</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navUpDown navbar navbar-expand-lg navbar-light py-2 border-bottom border-info">
    <div class="col-12 col-lg-10 p-2 mx-auto d-flex align-items-center position-relative">
        <div class="d-flex">
            <a class="navbar-brand ms-2" href="/">
                <span class="logo-1">YOUTH </span> <span class="logo-2">MM</span>
            </a>
            @auth()
                <div class="d-block d-md-none" style="width: 40px; height: 40px">
                    @if(auth()->user()->profile)
                        <a class="" href="{{route('profile')}}"><img class="rounded-circle w-100 h-100 profile-link-img profile" src="{{ asset('uploads/profiles/'.auth()->user()->profile) }}" alt=""></a>
                    @else
                        <a class="" href="{{route('profile')}}"><img class="rounded-circle w-100 h-100 profile-link-img profile" src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZmlsZXxlbnwwfHwwfHw%3D&w=1000&q=80" alt=""></a>
                    @endif
                </div>
            @endauth
        </div>
        @auth()
            <div class="d-none d-md-block position-absolute bottom-25 start-50" style="width: 60px; height: 60px">
                @if(auth()->user()->profile)
                    <a class="" href="{{route('profile')}}"><img class="rounded-circle w-100 h-100 profile-link-img" src="{{ asset('uploads/profiles/'.auth()->user()->profile) }}" alt=""></a>
                @else
                    <a class="" href="{{route('profile')}}"><img class="rounded-circle w-100 h-100 profile-link-img" src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8cHJvZmlsZXxlbnwwfHwwfHw%3D&w=1000&q=80" alt=""></a>
                @endif
            </div>
        @endauth
        <div class="ms-auto hideShow me-2">
            <ul class="list-unstyled d-flex me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="text-decoration-none active nav-fs text-dark" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="text-decoration-none active nav-fs text-dark" href="/posts">Posts</a>
                </li>
                @guest
                <li class="nav-item d-flex align-items-center">
                    <a class="text-decoration-none active nav-fs text-dark" href="/login">Login</a> <span class="mx-2">|</span> <a class="text-decoration-none active nav-fs text-dark" href="/register">Register</a>
                </li>
                @else
                <li class="nav-item">
                    <a href="javascript:void(0)" onclick="logout()" class="text-decoration-none active nav-fs text-dark" href="">Logout</a>
                </li>
                @endguest
            </ul>
        </div>

    </div>
</nav>

@yield('content')


<div class="subscribe-section py-5 px-2">
    <div class="col-md-10 col-lg-8 col-xl-6 p-4 py-5 mx-auto">
        <div class="card border border-0 p-3">
            <div class="text-center title-fs">
                Get In Touch With Us
            </div>
            <form id="subscriberForm" class="body-fs mt-3" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <button type="submit" class="btn btn-primary">Subscribe Now</button>
            </form>
        </div>
    </div>
</div>

<div class="footer-section">
    <div class="card shadow-lg border-top border-info border-bottom-0 border-left-0 border-right-0 p-3 py-5">
        <div class="row g-2">
            <div class="col-lg-4 p-3">
                <div class="fs-1 fw-bold p-2"><span class="hero-logo-1">YOUTH</span> <span class="hero-logo-2">MM</span></div>
                <div>
                    <span class="title-fs">YOUTH MM</span>
                    <span class="body-fs">
                                has been built for those who are studying web development. Start Register now and improve your skills by diving into our quality video contents.
                        </span>
                </div>
            </div>
            <div class="col-lg-4 p-3 d-flex justify-content-lg-center">
                <div>
                    <div class="title-fs">Navigation</div>
                    <ul class="list-unstyled body-fs mt-5">
                        <li>
                            <a href="/" class="text-decoration-none text-dark">Home</a>
                        </li>
                        <li class="my-2">
                            <a href="/posts" class="text-decoration-none text-dark">Posts</a>
                        </li>
                        @guest
                        <li>
                            <a href="/login" class="text-decoration-none text-dark">Login</a>
                        </li>
                        <li class="mt-2">
                            <a href="/register" class="text-decoration-none text-dark">Register</a>
                        </li>
                        @else
                        <li>
                            <a href="javascript:void(0)" onclick="logout()" class="text-decoration-none text-dark">Logout</a>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 p-3 d-flex justify-content-lg-end">
                <div>
                    <div class="title-fs">Contact Us</div>
                    <div class="mt-5 body-fs">
                        <div class="mb-2">
                            <a href="" class="text-decoration-none text-dark"><i class="fa-solid fa-phone me-2"></i> 09988808027</a>
                        </div>
                        <div>
                            <a href="" class="text-decoration-none text-dark"><i class="fa-solid fa-envelope me-2"></i> aungzawphyo@gmail.com</a>
                        </div>
                        <div class="mt-3">
                            <a href=""><i class="fa-brands fa-facebook fs-2"></i></a>
                            <a href="" class="text-danger"><i class="fa-brands fa-youtube fs-2 mx-2"></i></a>
                            <a href=""><i class="fa-brands fa-linkedin fs-2"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>

    $(document).ready(function () {

    })

    const logout = () => {
        $.post("{{route('post_logout')}}",
        {
            "_token": "{{ csrf_token() }}",
        },
        function(response){
            if( response.status == true ){
                window.location.href = '/';
            }else {
                alert(response.message);
            }
        });
    }

    $(document).ready(function () {

        $('#subscriberForm').on('submit', function(e){
            e.preventDefault();
            $('button').attr('disabled', '');
            let formData = new FormData($('#subscriberForm')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('subscribe') }}",
                statusCode: {
                    404: function() {
                        alert('404')
                    },
                    403: function() {
                        alert('403')
                    },
                    422: function() {
                        alert('422')
                    },
                    500: function() {
                        alert('500')
                    }
                } ,
                data: formData,
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    if (response.status == true){
                        console.log('success')
                        alert(response.message);
                        $('input').val('');
                        $('button').removeAttr('disabled');
                    } else {
                        alert(response.message);
                        $('button').removeAttr('disabled');
                    }

                },
                // error: function(response) {
                //     console.log(response.message);
                //     $('#alert-container').removeClass('d-none');
                //     $('#alert-message').html('');
                //     $('#alert-message').html(response.message);
                //     $('button').removeAttr('disabled');
                // }
            });
        })

    })
</script>

</script>

@yield('script')

</body>
</html>

