@extends('layouts.admin_layout')

@section('content')

    <div id="alert-container" class="p-3 col-lg-6 d-none">
        <div class="alert alert-warning alert-dismissible fade show " role="alert">
            <span id="alert-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <div class="p-3">
        <div class="card shadow col-lg-6">
            <div>
                <h3 class="p-3 border-bottom  border-3 border-info" style="font-family: 'Abyssinica SIL', serif">Add Category</h3>
            </div>
            <form id="categoryForm" class="p-3" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control fs" id="name" placeholder="Enter category name">
                </div>
                <button type="submit" class="btn btn-primary fs">Save</button>
            </form>
        </div>
    </div>

    @endsection

    @section('script')
    
    <script>
        $(document).ready(function () {
            
            $('#categoryForm').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#categoryForm')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('categoryEntry') }}",
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
                            $('#alert-container').removeClass('d-none');
                            $('#alert-message').html('');
                            $('#alert-message').html(response.message);
                            $('input').val('');
                            $('button').removeAttr('disabled');
                        } else {
                            console.log(response.message);
                            $('#alert-container').removeClass('d-none');
                            $('#alert-message').html('');
                            $('#alert-message').html(response.message);
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
    
    @endsection
