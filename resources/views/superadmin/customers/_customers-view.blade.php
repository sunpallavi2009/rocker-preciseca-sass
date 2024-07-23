@extends("layouts.app")
@section('title', __('Customers | Preciseca'))
@section("style")
<link href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection
@section("wrapper")
    <div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Customers</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Customers</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
      
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                </div>
                
                <div class="col-lg-12">
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="my-1 text-info">{{ $ledger->language_name }}</h4>
                                    </div>
                                    
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-2">
                                            <p class="mb-0 font-13 btn btn border-0"><i class='bx bx-folder'></i> {{ $ledger->parent }}</p>
                                        </div>
                                        <div class="col-lg-2">
                                            <p class="btn btn-outline-danger border-1"><i class='lni lni-warning'></i> Overdue</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row p-2">
                                    <div class="col-lg-9" style="padding: 25px;background: #eee;border-bottom-left-radius: 15px;border-top-left-radius: 15px;">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <p class="mb-0 font-13">Total Invoices</p>
                                                <h6><h6 id="totalInvoices">0</h6></h6>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="mb-0 font-13">Opening Balance</p>
                                                <h6>31</h6>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="mb-0 font-13">Total Debit</p>
                                                <h6 id="totalDebit"></h6>
                                            </div>
                                            <div class="col-lg-3">
                                                <p class="mb-0 font-13">Total Credit</p>
                                                <h6 id="totalCredit"></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3" style="padding: 25px;background: #e7d9d9;border-bottom-right-radius: 15px;border-top-right-radius: 15px;">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <p class="mb-0 font-13 btn btn border-0"><i class='bx bx-info-circle'></i></p>
                                                </div>
                                                <div class="col-lg-10">
                                                    <p class="mb-0 font-13">Net Outstanding</p>
                                                    <h6>31(Debit)</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="stepper1" class="bs-stepper">
                    <div class="card">
                    
                    </div>
                </div>
                
                <div id="stepper2" class="bs-stepper">
               
                      
                        <div class="card-header">
                            <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
                                <div class="step active" data-target="#test-nl-1">
                                    <div class="step-trigger" role="tab" id="stepper2trigger1" aria-controls="test-nl-1" aria-selected="true">
                                    <div class="bs-stepper-circle"><i class="bx bx-user fs-4"></i></div>
                                    <div class="">
                                        <h5 class="mb-0 steper-title">Overview</h5>
                                        {{-- <p class="mb-0 steper-sub-title">Enter Your Details</p> --}}
                                    </div>
                                    </div>
                                </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-nl-2">
                                    <div class="step-trigger" role="tab" id="stepper2trigger2" aria-controls="test-nl-2" aria-selected="false">
                                        <div class="bs-stepper-circle"><i class="bx bx-info-circle fs-4"></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Info</h5>
                                        </div>
                                    </div>
                                    </div>
                                <div class="bs-stepper-line"></div>
                                <div class="step" data-target="#test-nl-3">
                                    <div class="step-trigger" role="tab" id="stepper2trigger3" aria-controls="test-nl-3" aria-selected="false">
                                        <div class="bs-stepper-circle"><i class="bx bx-file fs-4"></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Invoices</h5>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="bs-stepper-line"></div>
                                    <div class="step" data-target="#test-nl-4">
                                        <div class="step-trigger" role="tab" id="stepper2trigger4" aria-controls="test-nl-4" aria-selected="false">
                                        <div class="bs-stepper-circle"><i class="bx bx-briefcase fs-4"></i></div>
                                        <div class="">
                                            <h5 class="mb-0 steper-title">Ledger View</h5>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="card-body">
                        
                            <div class="bs-stepper-content">
                            <form onsubmit="return false">
                                <div id="test-nl-1" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepper2trigger1">
                                <h5 class="mb-1">Customer Outstanding</h5>
    
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                     
                                    </div>
                                </div><!---end row-->
                                
                                </div>
    
                                <div id="test-nl-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger2">
    
                                    <h5 class="mb-1">Contact Details</h5>
        
                                    <div class="row g-3 pt-4">
                                        <div class="col-12 col-lg-4">
                                            <p>E-mail Address</p>
                                            <p>{{ $ledger->language_name ?? '-' }}</p>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <p>Phone Number</p>
                                            <p>{{ $ledger->language_name ?? '-' }}</p>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <p>Address</p>
                                            <p>{{ $ledger->address ?? '-' }}</p>
                                        </div>
                                    </div><!---end row-->

                                    <h5 class="mb-1">Accounting & Taxation</h5>
    
                                    <div class="row g-3 pt-4">
                                        <div class="col-12 col-lg-4">
                                            <p>GSTIN</p>
                                            <p>{{ $ledger->gst_in ?? '-' }}</p>
                                        </div>
                                    </div><!---end row-->


                                    <h5 class="mb-1">Account Details</h5>
    
                                    <div class="row g-3 pt-4">
                                        <div class="col-12 col-lg-4">
                                            <p>Credit limit</p>
                                            <p>-</p>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <p>Credit Period</p>
                                            <p>-</p>
                                        </div>
                                    </div><!---end row-->
                                
                                </div>
    
                                <div id="test-nl-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger3">
                                <h5 class="mb-1">Your Education Information</h5>
                                <p class="mb-4">Inform companies about your education life</p>
    
                                <div class="row g-3">
                                    <div class="col-12 col-lg-6">
                                        <label for="SchoolName" class="form-label">School Name</label>
                                        <input type="text" class="form-control" id="SchoolName" placeholder="School Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="BoardName" class="form-label">Board Name</label>
                                        <input type="text" class="form-control" id="BoardName" placeholder="Board Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="UniversityName" class="form-label">University Name</label>
                                        <input type="text" class="form-control" id="UniversityName" placeholder="University Name">
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label for="InputCountry" class="form-label">Course Name</label>
                                        <select class="form-select" id="InputCountry" aria-label="Default select example">
                                            <option selected="">---</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                            </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center gap-3">
                                            <button class="btn btn-outline-secondary px-4" onclick="stepper2.previous()"><i class="bx bx-left-arrow-alt me-2"></i>Previous</button>
                                            <button class="btn btn-primary px-4" onclick="stepper2.next()">Next<i class="bx bx-right-arrow-alt ms-2"></i></button>
                                        </div>
                                    </div>
                                </div><!---end row-->
                                
                                </div>
    
                                <div id="test-nl-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger4">
                                <h5 class="mb-1">Ledger View</h5>
    
                                <div class="row g-3 pt-4">
                                    @include('superadmin.customers._ledger-view', ['ledger' => $ledger])
                                </div><!---end row-->
                                
                                </div>
                            </form>
                            </div>
                            
                        </div>

                 
                </div>

            </div>
        </div>

            
    </div>
</div>
@endsection
@push('css')

@endpush
@push('javascript')
<script>
	new PerfectScrollbar('.email-navigation');
	new PerfectScrollbar('.email-list');
</script>
@endpush
@section("script")
<script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bs-stepper/js/main.js') }}"></script>

<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#voucherEntriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("customers.vouchers", ["customer" => $ledger->guid]) }}',
                columns: [
                    { data: 'voucher_date', name: 'voucher_date' },
                    { data: 'ledger_name', name: 'ledger_name' },
                    { data: 'voucher_number', name: 'voucher_number' },
                    { data: 'voucher_type', name: 'voucher_type' },
                    { data: 'credit', name: 'credit', className: 'text-end' },
                    { data: 'debit', name: 'debit', className: 'text-end' }
                ],
                initComplete: function(settings, json) {
                    // Update the total count on initialization
                    $('#totalInvoices').text(json.recordsTotal);
                },
                drawCallback: function(settings) {
                    // Update the total count on each draw (refresh)
                    $('#totalInvoices').text(settings.json.recordsTotal);
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Calculate total credit and debit
                    var totalCredit = api.column(4).data().reduce(function(a, b) {
                        // Ensure that a and b are numbers
                        a = parseFloat(a) || 0;
                        b = parseFloat(b) || 0;
                        return a + b;
                    }, 0);

                    var totalDebit = api.column(5).data().reduce(function(a, b) {
                        // Ensure that a and b are numbers
                        a = parseFloat(a) || 0;
                        b = parseFloat(b) || 0;
                        return a + b;
                    }, 0);

                    // Update footer
                    $(api.column(4).footer()).html(totalCredit.toFixed(2));
                    $(api.column(5).footer()).html(totalDebit.toFixed(2));

                    // Update the Total Debit and Total Credit sections
                    $('#totalDebit').text(totalDebit.toFixed(2));
                    $('#totalCredit').text(totalCredit.toFixed(2));
                }

            });
        });
    </script>     
@endsection