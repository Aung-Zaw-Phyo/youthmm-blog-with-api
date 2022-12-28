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
                        <th scope="col" class="py-3">Email</th>
                        <th scope="col" class="py-3">Created At</th>
                        <th scope="col" class="py-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $count = 0; ?>
                    @foreach ($users as $user)
                        <tr class="record-{{ $user->id }}">
                            <td class="py-3">{{ $count += 1 }}</td>
                            <td class="py-3">{{ $user->name }} | {{ $user->id }} | {{ $user->updated_at->diffForHumans() }}</td>
                            <td class="py-3">{{ $user->email }}</td>
                            <td class="py-3">{{ $user->updated_at->diffForHumans() }}</td>
                            <td class="py-3 d-flex">
                                <div class="me-3">
                                    @if ($user->ban_date_limit == 0)
                                        <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#user-{{ $user->id }}">Ban</a>
                                    @else
                                        <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#user-{{ $user->id }}">Edit</a>
                                    @endif
                                </div>
                                {{-- modal box start  --}}
                                <div class="modal fade" id="user-{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title"><span class="text-danger">Ban</span> <span class="text-primary">{{ $user->name }}</span></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body py-3">
                                                @if ($user->ban_date_limit > 0)
                                                    <div class="mb-3 pb-3 border-bottom border-dark">
                                                        <div class="text-danger">This user had been banned for <b>{{ $user->ban_date_limit }}</b> days!</div>
                                                        <?php $diffTime = now()->diffInMinutes($user->updated_at->addDays($user->ban_date_limit)) ?>
                                                        <?php $days = ($diffTime / 60) / 24 ?>
                                                        @if ( $days < 1 )
                                                            <div class="my-3">Least date is {{ round($diffTime / 60) }} hours. </div>
                                                        @else
                                                            <div class="my-3">Least date is {{ round(($diffTime / 60) / 24)  }} days.</div>
                                                        @endif
                                                        <button onclick="notBan({{ $user->id }})" class="btn btn-primary cancel-ban-btn">Not Ban</button>
                                                    </div>
                                                @endif
                                                <form id="user_ban_form_{{ $user->id }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                                    <label for="ban">Ban Limit Date</label>
                                                    <select name="ban_date_limit" class="form-control mt-2" id="ban">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                        <option value="25">25</option>
                                                        <option value="30">30</option>
                                                    </select>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                @if ($user->ban_date_limit > 0)
                                                    <button disabled onclick="action({{ $user->id }})" type="submit" class="btn btn-danger me-3 action-btn">Save </button>
                                                @else
                                                    <button onclick="action({{ $user->id }})" type="submit" class="btn btn-danger me-3 action-btn">Save </button>
                                                @endif
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- modal box end  --}}
                                <button onclick="deleteUser({{ $user->id }})" type="submit" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                


            </div>
        </div>
        <div class="mt-5 col-lg-10">
            {{ $users->links() }}
        </div>
    </div>

@endsection

@section('script')

<script>
        let action = (id) => {
            $("#user_ban_form_"+id).submit(submit_form(id));
        }

        let submit_form = (id) => {
            $('.action-btn').attr('disabled', '');
            let formData = new FormData($("#user_ban_form_"+id)[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{ route('banUser') }}",
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
                        window.location.href = window.location.href;
                        $('.action-btn').removeAttr('disabled'); 
                    } else {
                        alert(response.message);
                        $('.action-btn').removeAttr('disabled'); 
                    }
                    
                },
                
            });
        }
        
        let notBan = (id) => {
            $('.cancel-ban-btn').attr('disabled', '');
            $.post("{{route('cancel_ban')}}",
            {
                "_token": "{{ csrf_token() }}",
                "id" : id 
            },
            function(response){
                if( response.status == true ){
                    window.location.href = window.location.href;
                    $('.cancel-ban-btn').removeAttr('disabled', '');
                }else {
                    alert(response.message);
                    $('.cancel-ban-btn').removeAttr('disabled', '');
                }
            });
        }

        const deleteUser = (id) => {
            $.post("{{route('delete_user')}}",
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


