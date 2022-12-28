@extends('layouts.admin_layout')

@section('content')
    <div class="p-3">
        <div class="card col-lg-10">
            <div>
                <h3 class="p-3 border-bottom  border-3 border-info" style="font-family: 'Abyssinica SIL', serif">Users</h3>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-hover fs">
                    <thead>
                      <tr>
                        <th scope="col" class="py-3">No</th>
                        <th scope="col" class="py-3">Thumbnail</th>
                        <th scope="col" class="py-3">Title</th>
                        <th scope="col" class="py-3">Body</th>
                        <th scope="col" class="py-3">Details</th>
                        <th scope="col" class="py-3">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $count = 0; ?>
                        @foreach ($blogs as $blog)
                        <tr class="record-{{ $blog->id }}">
                            <td class="py-3">{{ $count += 1 }}</td>
                            <td class="py-3">
                                @if ($blog->thumbnail)
                                <img class="" width="80" src="{{ asset("uploads/$blog->thumbnail") }}" alt="">
                                @endif
                            </td>
                            <td class="py-3">{{ $blog->title }}</td>
                            <td class="py-3">{{ Str::substr($blog->body, 0, 30) }}</td>
                            <td class="py-3">
                                <div class="me-3">
                                    <a href="{{route('viewBlog', $blog->token)}}" class="btn btn-primary">View</a>
                                </div>
                            </td>
                            <td class="py-3 d-flex">
                                <div class="me-3">
                                    <a href="{{route('editBlog', $blog->token)}}" class="btn btn-primary">Edit</a>
                                </div>
                                <div>
                                    <button onclick="deleteBlog( {{ $blog->id }} )" type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-5 col-lg-10">
            {{ $blogs->links() }}
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            console.log('run');
        })
        const deleteBlog = (id) => {
            $.post("{{route('deleteBlog')}}",
            {
                "_token": "{{ csrf_token() }}",
                "blog_id": id,
            },
            function(response){
                if( response.status == true ){
                    $('.record-'+id).fadeOut('slow');
                }else {
                    alert('Server error!')
                }


                // if(data.status == 200)
                // {
                //     $('.get-tr'+id).fadeOut("slow");
                // }
                // console.log(data);
            });
        }
    </script>
@endsection



