@extends('layouts.admin_layout')
@section('content')

    <div class="p-3">
        <div class="card col-lg-10">
            <div>
                <h3 class="p-3 border-bottom  border-3 border-info" style="font-family: 'Abyssinica SIL', serif">Subscribers</h3>
            </div>
            <div class="table-responsive p-3">
                <table class="table table-hover fs">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3">No</th>
                        <th scope="col" class="py-3">Name</th>
                        <th scope="col" class="py-3">Email</th>
                        <th scope="col" class="py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; ?>
                    @foreach ($subscribers as $subscriber)
                        <tr class="record-{{ $subscriber->id }}">
                            <td class="py-3">{{ $count += 1 }}</td>
                            <td class="py-3">{{ $subscriber->name }}</td>
                            <td class="py-3">{{ $subscriber->email }}</td>
                            <td class="py-3 d-flex">
                                <button onclick="deleteSubscriber({{ $subscriber->id }})" type="submit" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="mt-5 col-lg-10">
            {{ $subscribers->links() }}
        </div>
    </div>

@endsection

@section('script')
<script>
        const deleteSubscriber = (id) => {
            $.post("{{route('delete_subscriber')}}",
            {
                "_token": "{{ csrf_token() }}",
                "id": id,
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


