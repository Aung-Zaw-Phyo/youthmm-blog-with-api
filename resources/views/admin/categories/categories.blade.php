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
                        <th scope="col" class="py-3">Name</th>
                        <th scope="col" class="py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; ?>
                    @foreach ($categories as $category)
                        <tr class="record-{{ $category->id }}">
                            <td class="py-3">{{ $count += 1 }}</td>
                            <td class="py-3">{{ $category->name }}</td>
                            <td class="py-3 d-flex ">
                                <div class="me-3">
                                    <a href="{{route('editCategory', $category->token)}}" class="btn btn-primary">Edit</a>
                                </div>
                                <div>
                                    <button type="submit" onclick="deleteCategory( {{ $category->id }} )" class="btn btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-5 col-lg-10">
            {{ $categories->links() }}
        </div>
    </div>

@endsection

@section('script')

<script>
    $(document).ready(function () {
        console.log('run');
    })
    const deleteCategory = (id) => {
        $.post("{{route('deleteCategory')}}",
        {
            "_token": "{{ csrf_token() }}",
            "category_id": id,
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

