@extends("FrontDashboard.master")
@section("content")

<div class="view_dashboard">
    <div class="main_page">
        <div class="add_product_main product_detail">
            <div class="title_addproduct view-offer">View Patient</div>
            <a href="{{ route('users.show',$patient->hospital_id) }}" class="cancel_btn btns">Back</a>
        </div>
    </div>
   <div class="view_dashboard_table">
        <div class="main_addproduct_form">
            <div class="table-responsive">
                <table class="table patient_table   " id="patient-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>File Name</th>
                            <th>Machine</th>
                            <th>Record</th>
                        </tr>
                    </thead>
                    @if($sensors->count() == 0)
                        <tr>
                            <td class="text-center" colspan="5">No Data Found</td>
                        </tr>
                    @else
                        @foreach ($sensors as $sensor)
                            <tr>
                                <td>{{ date("Y-m-d",strtotime($sensor->created_at)) }}</td>
                                <td>{{ $sensor->file_name }}</td>
                                <td>{{ $sensor->machine_id }}</td>
                                <td>{{ $sensor->record_id }}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
           </div>
           <div class="row align-items-center">
                <div class="col-12">
                    <nav aria-label="Page navigation example mt-3">
                        <ul class="pagination pagination_nav d-flex justify-content-end align-items-center flex-wrap">
                            @if ($sensors->onFirstPage())
                                <li class="paginate_button page-item">
                                    <a href="#" class="page-link">
                                           <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item paginate_button">
                                    <a href="{{ $sensors->previousPageUrl() }}" rel="prev"  class="page-link">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                            @endif

                            @foreach ($sensors->getUrlRange(1, $sensors->lastPage()) as $page => $url)
                                <li class="{{ $page == $sensors->currentPage() ? 'active' : '' }} page-item paginate_button" >
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($sensors->hasMorePages())
                                <li class="paginate_button page-item">
                                    <a href="{{ $sensors->nextPageUrl() }}" rel="next" class="page-link fw-bold">
                                      <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="paginate_button page-item">
                                    <a href="#" class="page-link">
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
