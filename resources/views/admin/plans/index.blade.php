@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Payment Plans</h2>
                @can('plans-create')
                   <a href="{{ route('plans.create') }}" class="add-btn">Add Plans</a>
                @endcan
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="plans-list">
                            <thead>
                                <tr>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Package Name</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Days</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Cost (INR)</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Cost (USD)</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Cost (EURO)</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Order</span>
                                    </th>
                                    <th width="3%"class="bg-white border-black whitespace-nowrap p-0">
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
            var table = $('#plans-list').DataTable({
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
                ajax: "{{ route('plans.index') }}",
                columns: [
                    {
                        data: 'name', 
                        name: 'name'
                    },
                    {
                        data: 'days',
                        name: 'days',
                        searchable: true
                    },
                    {
                        data: 'cost',
                        name: 'cost',
                    },
                    {
                        data: 'cost_usd',
                        name: 'cost_usd',
                    },
                    {
                        data: 'cost_euro',
                        name: 'cost_euro',
                    },
                    {
                        data: 'order_by',
                        name: 'order_by',
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
                order: [7, 'desc'],
            });
            $(document).on('click', '.delete_btn', function () {
                var url = $(this).data('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(data) {
                                if (data.status == 1) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Plan has been deleted.',
                                        'success'
                                    );
                                } else if (data.status == 0) {
                                    Swal.fire(
                                        'Active Plan!',
                                        data.message,  // Use data.message instead of response.message
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue deleting the plan.',
                                        'error'
                                    );
                                }
                                
                                $('#plans-list').DataTable().ajax.reload(null, false);  
                            },
                            error: function (xhr, status, error) {
                                console.error('Delete error: ', error);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
