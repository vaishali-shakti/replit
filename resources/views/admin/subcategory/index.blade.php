@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Sub Category Management</h2>
                 @can('subcategory-create')
                   <a href="{{ route('subcategory.create') }}" class="add-btn">Add Sub Category</a>
                @endcan
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="subcategory-list">
                            <thead>
                                <tr>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Main Category</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Sub Category</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Description</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Type</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Image</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Order</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Status</span>
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
            var table = $('#subcategory-list').DataTable({
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
                ajax: "{{ route('subcategory.index') }}",
                columns: [
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'order_by',
                        name: 'order_by'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                order: [8, 'desc'],
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
                            toastr.success('Subcategory status updated successfully');
                            table.ajax.reload();
                        } else {
                            toastr.error(data.message);
                        }
                    }
                })
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
                                        'SubCategory has been deleted.',
                                        'success'
                                    );
                                } else if(response.status == 0){
                                    Swal.fire(
                                        'Active Plan!',
                                        response.message,
                                        'error'
                                    );
                                }
                                else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue deleting the SubCategory.',
                                        'error'
                                    );
                                }
                                $('#subcategory-list').DataTable().ajax.reload(null, false);
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
