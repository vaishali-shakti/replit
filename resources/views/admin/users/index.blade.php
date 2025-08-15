@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">User Management</h2>
                @can('user-create')
                    @if(auth()->guard('web')->user()->role_id != 5 || (auth()->guard('web')->user()->role_id == 5 && org_user_count() < auth()->guard('web')->user()->user_limit))
                        <a href="{{ route('users.create') }}" class="add-btn">Add User</a>
                    @endif
                @endcan
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="users-list">
                            <thead>
                                <tr>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Name</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Date of birth</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Time of birth</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Place of birth</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Mobile No. 1</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Mobile No. 2</span>
                                    </th>
                                    <th width="6%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Email</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Discomfort</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">User Type</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Parent User</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Image</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Status</span>
                                    </th>
                                     <th width="6%"class="bg-white border-black whitespace-nowrap p-0">
                                        <span class=" border-0 text-18 d-block text-center offer-box">Action</span>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#users-list').DataTable({
                responsive: true,
                scrollX: true,
                language: {
                    "sSearch": "",
                    "searchPlaceholder": "Search",
                    paginate: {
                        next: '<i class="fa fa-angle-right">',
                        previous: '<i class="fa fa-angle-left">'
                    }
                },
                oLanguage: {
                    sLengthMenu: "_MENU_",
                },
                serverSide: true,
                processing: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'dob',
                        name: 'dob'
                    },
                    {
                        data: 'time_of_birth',
                        name: 'time_of_birth'
                    },
                    {
                        data: 'place_of_birth',
                        name: 'place_of_birth'
                    },
                    {
                        data: 'mobile_number_1',
                        name: 'mobile_number_1'
                    },
                    {
                        data: 'mobile_number_2',
                        name: 'mobile_number_2'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'discomfort',
                        name: 'discomfort'
                    },
                    {
                        data: 'role_id',
                        name: 'role_id'
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data:"created_at",
                        name:"created_at",
                        visible:false,
                        searchable: false,
                    }
                ],
                order: [13,'desc']
            });

            $(document).on('click', '.toggle_status', function() {
                var url = $(this).attr('data-href');
                // alert();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'status': $(this).prop('checked') == true ? '1' : '2',
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            toastr.success('User status updated successfully');
                            table.ajax.reload();
                        } else {
                            toastr.error(data.message);
                        }
                    }
                })
        });

            $(document).on('click', ".delete_btn", function() {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn",
                    confirmButtonText: 'Yes, delete it!',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'You need to write something!'
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = $(this).attr('data-href');
                        var token = '<?php echo csrf_token(); ?>';
                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: token,
                                _method: 'DELETE',
                            },
                            success: function (response) {
                                if (response.status === 1) {
                                    table.draw();
                                    Swal.fire(
                                        'Deleted!',
                                        'User has been deleted.',
                                        'success'
                                    );
                                } else if(response.status == 0){
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue deleting the User.',
                                        'error'
                                    );
                                }
                                $('#user-list').DataTable().ajax.reload(null, false);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
