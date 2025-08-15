@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Banner Management</h2>
                 @can('banner-create')
                   <a href="{{ route('banner.create') }}" class="add-btn">Add Banner</a>
                @endcan
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="banner-list">
                            <thead>
                                <tr>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Title</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Image</span>
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
            var table = $('#banner-list').DataTable({
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
                ajax: "{{ route('banner.index') }}",
                columns: [
                    {
                        data: 'title', 
                        name: 'title'
                    },
                    {
                        data: 'image', 
                        name: 'image',
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
                                        'Banner has been deleted.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'There was an issue deleting the banner.',
                                        'error'
                                    );
                                }
                                $('#banner-list').DataTable().ajax.reload(null, false);  
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
