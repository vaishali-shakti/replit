@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Super Category Management</h2>
                 @can('category-create')
                   <a href="{{ route('category.create') }}" class="add-btn">Add Super Category</a>
                @endcan
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="category-list">
                            <thead>
                                <tr>
                                    <th width="60%" class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Name</span>
                                    </th>
                                    <th width="10%" class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Order</span>
                                    </th>
                                    <th width="30%"class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Action</span>
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
            var table = $('#category-list').DataTable({
                stateSave: true,
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
                ajax: "{{ route('category.index') }}",
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'order_by',
                        name: 'order_by'
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
                order: [3, 'desc'],
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
                            success: function (response) {
                                            if (response.status === 1) {
                                                table.draw();
                                                Swal.fire(
                                                    'Deleted!',
                                                    'Category has been deleted.',
                                                    'success'
                                                );
                                            } else if(response.status == 0){
                                                Swal.fire(
                                                    'Deletion Not Allowed!',
                                                    response.message,
                                                    'error'
                                                );
                                            }
                                            else {
                                                Swal.fire(
                                                    'Error!',
                                                    'There was an issue deleting the Category.',
                                                    'error'
                                                );
                                            }
                                            $('#maincategory-list').DataTable().ajax.reload(null, false);
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
