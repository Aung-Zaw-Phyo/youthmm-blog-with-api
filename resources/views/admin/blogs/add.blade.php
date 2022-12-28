@extends('layouts.admin_layout')

@section('content')

    @if(session()->get('warning'))
        <div class="p-3 col-lg-6">
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                {{session('warning')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div id="alert-container" class="p-3 col-lg-6 d-none">
        <div class="alert alert-warning alert-dismissible fade show " role="alert">
            <span id="alert-message"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <div class="p-3">
        <div class="card shadow col-lg-6">
            <div>
                <h3 class="p-3 border-bottom  border-3 border-info" style="font-family: 'Abyssinica SIL', serif">Add Blog</h3>
            </div>
            {{-- <form id="blogForm" class="p-3 fs" action="{{route('blogEntry')}}" method="POST" enctype="multipart/form-data"> --}}
            <form id="blogForm" class="p-3 fs" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control fileInput" id="thumbnail">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control name" id="title" placeholder="Enter blog title">
                    @error('title')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea class="form-control" name="body" id="body" cols="30" rows="5" placeholder="Enter blog body"></textarea>
                    @error('body')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select name="category_id" class="form-control" id="category">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="create-btn btn btn-primary">Create</button>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function () {
            
            $('#blogForm').on('submit', function(e){
                e.preventDefault();
                $('button').attr('disabled', '');
                let formData = new FormData($('#blogForm')[0]);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{ route('blogEntry') }}",
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
                            $('textarea').val('');
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

