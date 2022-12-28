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
    <style>
        body{
            background-color: #f7f7ff;
        }
        .card{
            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px !important;
        }
        @media screen and (max-width: 992px) {
            .welcome {
                font-size: 25px !important;
            }
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 mx-auto p-2 pt-5">
                <div class="card border border-0 p-3">
                    <div class="fs-1 fw-bold p-2 title-fs text-center welcome">Welcome To <span class="hero-logo-1">YOUTH</span> <span class="hero-logo-2">MM</span></div>
                    <form id="userForm" class="body-fs mt-3">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary me-3">Login</button>
                            <span>You don't have an account! <a href="/register">Register</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            
            $('#userForm').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#userForm')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('post_login') }}",
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
                            window.location.href = "{{ route('page_home') }}";
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


</body>
</html>



