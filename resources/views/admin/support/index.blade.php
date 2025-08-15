@extends('FrontDashboard.master')
@section('content')
    <div class="container px-0">
        <div class="Business-profile">
            <div class="d-flex flex-wrap align-items-center justify-content-sm-between justify-content-center gap-3 px-2 mx-1">
                <h2 class="d-block text-21 fw-bold offer-title text-capitalize">Support Management</h2>
            </div>
            <div class="dashboard-table pt-3">
                <div class="table_plan-holder">
                    <div class="">
                        <table class="mb-0 data-table" id="support-list">
                            <thead>
                                <tr>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Date</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Ticket Number</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Name</span>
                                    </th>
                                    <th width="2%"  class="bg-white border-black whitespace-nowrap p-0">
                                        <span class="border-0 text-18 d-block text-center offer-box">Status</span>
                                    </th>
                                     <th width="2%"class="bg-white border-black whitespace-nowrap p-0">
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
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.13.5/sorting/datetime.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#support-list').DataTable({
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
                processing: true,
                serverSide: true,
                ajax: "{{ route('support.index') }}",
                columns: [
                    {
                        data:'formatted_created_at',
                        name:'formatted_created_at',
                        render: function (data) {
                            var date = new Date(data);
                            // Extract and format day, month, and year
                            var day = ("0" + date.getDate()).slice(-2);
                            var month = ("0" + (date.getMonth() + 1)).slice(-2);
                            var year = date.getFullYear();
                            // Extract and format hours and minutes
                            var hours = date.getHours();
                            var minutes = ("0" + date.getMinutes()).slice(-2);
                            // Determine AM/PM and convert to 12-hour format
                            var ampm = hours >= 12 ? "PM" : "AM";
                            hours = hours % 12 || 12; // Convert 0 to 12 for 12-hour format
                            // Combine into the desired format
                            return `${day}-${month}-${year} ${("0" + hours).slice(-2)}:${minutes} ${ampm}`;
                        }
                    },
                    {
                        data:'ticket_no',
                        name:'ticket_no',

                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'message_status',
                        name: 'message_status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'msg_status',
                        name: 'msg_status',
                        visible: false,
                        searchable: false
                    }
                ],
                order: [5, 'desc']
            });
        });
    </script>
@endsection
