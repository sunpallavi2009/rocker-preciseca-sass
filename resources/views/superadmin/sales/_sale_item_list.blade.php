@extends("layouts.main")
@section('title', __('Reports | Preciseca'))
@section("style")
<link href="{{ url('assets/plugins/bs-stepper/css/bs-stepper.css') }}" rel="stylesheet" />
<link href="{{ url('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
<style>
    .table-responsive-scroll {
        max-height: 500px; /* Set to your preferred height */
        overflow-y: auto;
        overflow-x: hidden !important; /* Optional, hides horizontal scrollbar */
        border: 1px solid #ddd;
    }

</style>
@endsection
@section("wrapper")
    <div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Reports</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Sales</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->


         <!--start email wrapper-->
         <div class="email-wrapper">
            <div class="email-sidebar">
                <div class="email-sidebar-header d-grid"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-left-arrow-alt me-2'></i> Sales</a>
                </div>
                <div class="email-sidebar-content">
                    <div class="email-navigation" style="height: 530px;">
                        <div class="list-group list-group-flush">
                            @foreach($menuItems as $item)
                                <a href="{{ route('sales.items', ['SaleItem' => $item->id]) }}" class="list-group-item d-flex align-items-center {{ request()->route('SaleItem') == $item->id ? 'active' : '' }}" style="border-top: none;">
                                    <i class='bx {{ $item->icon ?? 'bx-default-icon' }} me-3 font-20'></i>
                                    <span>{{ $item->party_ledger_name }}</span>
                                    @if(isset($item->badge))
                                        <span class="badge bg-primary rounded-pill ms-auto">{{ $item->badge }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="email-header d-xl-flex align-items-center padding-0" style="height: auto;">
                
                <div class="d-flex align-items-center">
                    <div class="">
                        <h4 class="my-1 text-info">{{ $saleItem->party_ledger_name }} </h4>
                    </div>
                </div>
               
            </div>
            
            <div class="email-content py-2">
                <div class="">
                    <div class="email-list">
                       
                        <div class="col-lg-12">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-info">
                                    <div class="card-body">
        
                                        <div class="row p-2">
                                            <div class="col-lg-9" style="padding: 25px;background: #eee;border-bottom-left-radius: 15px;border-top-left-radius: 15px;">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <p class="mb-0 font-13">Issued Date</p>
                                                        <h6>{{ \Carbon\Carbon::parse($saleItem->voucher_date)->format('j F Y') }}</h6>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="mb-0 font-13">Amount</p>
                                                        <h6 id="totalInvoiceAmount"></h6>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="mb-0 font-13">Pending Amount</p>
                                                        <h6></h6>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <p class="mb-0 font-13">Due Date</p>
                                                        <h6></h6>
                                                    </div>
                                                </div>
                                            </div>
        
                                            <div class="col-lg-3" style="padding: 25px;background: #e7d9d9;border-bottom-right-radius: 15px;border-top-right-radius: 15px;">
                                                <div class="col-lg-12">
                                                            <p class="mb-0 font-13">Status</p>
                                                            <h6 class="text-info">Status</h6>
                                                </div>
                                            </div>
        
        
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 px-2">
                            <div class="col">
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="bx bx-group fs-4"></i>&nbsp; Party Details <p class="" style="margin-left: auto;">Bill to: {{ $saleItem->party_ledger_name }}</p>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">	
                                                <p class="mb-0 font-16">Bill to</p>
                                                <strong class="mb-0 font-16">{{ $saleItem->party_ledger_name }}</strong>
                                                @foreach($ledgerData as $ledgerData)
                                                    <p class="mb-0 font-16">{{ $ledgerData->address }}</p>
                                                    <p class="mb-0 font-16">{{ $ledgerData->state }}</p>
                                                @endforeach
                                                Place of supply<p class="mb-0 font-16">{{ $saleItem->place_of_supply }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <i class="bx bx-cube fs-4"></i>&nbsp;  Items & Services <p class="" style="margin-left: auto;">{{ $totalCountItems }} Items</p>
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">	
                                                <div class="table-responsive table-responsive-scroll  border-0">
                                                    <table class="table table-striped" id="sale-item-table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <td>Name</td>
                                                                <td>HSN</td>
                                                                <td>QTY</td>
                                                                <td>&#8377 Rate</td>
                                                                <td>GST</td>
                                                                <td>Dsic %</td>
                                                                <td>&#8377 Amount</td>
                                                            </tr>
                                                        </thead>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="5"></th>
                                                                <th style="text-align:right">Subtotal</th>
                                                                <th style="text-align:right" id="subtotal"></th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="5"></th>
                                                                <th style="text-align:right">Round off</th>
                                                                <th style="text-align:right" id="roundOff">{{ $totalRoundOff }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="5"></th>
                                                                <th style="text-align:right">IGST @18%</th>
                                                                <th style="text-align:right" id="igst18">{{ $totalIGST18 }}</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="5"></th>
                                                                <th style="text-align:right">Total Invoice Value</th>
                                                                <th style="text-align:right" id="totalInvoiceValue"></th>
                                                            </tr>
                                                        </tfoot>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingFour">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                <i class="bx bx-group fs-4"></i>&nbsp; Additional Details 
                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            Reference No.
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <p class="mb-0 font-16">: {{ $saleItem->reference_no }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            Reference Date
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <p class="mb-0 font-16">: {{ \Carbon\Carbon::parse($saleItem->reference_date)->format('j F Y') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingThree">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                               <i class="bx bx-book-open fs-4"></i>&nbsp; Accounting Details <p class="" style="margin-left: auto;">4 A/c's impacted</p>
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">	
                                                <div class="table-responsive table-responsive-scroll  border-0">
                                                    <table class="table table-striped" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <td>Account Name</td>
                                                                <td>&#8377 Credit</td>
                                                                <td>&#8377 Debit</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Round Off</td>
                                                                <td>&#8377 {{ $totalRoundOff }}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>IGST @18%</td>
                                                                <td>&#8377 {{ $totalIGST18 }}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                @foreach($uniqueGstLedgerSources as $gstLedgerSource)
                                                                    <td>{{ $gstLedgerSource }}</td>
                                                                @endforeach
                                                                <td>&#8377 {{ $subtotalsamount }}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ $saleItem->party_ledger_name }}</td>
                                                                <td></td>
                                                                <td id="totalLedgerAmount"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        
            <!--start email overlay-->
            <div class="overlay email-toggle-btn-mobile"></div>
            <!--end email overlay-->
        </div>
        <!--end email wrapper-->


            
    </div>
</div>




@endsection
@push('css')
@include('layouts.includes.datatable-css')
@endpush
@push('javascript')
<script>
	new PerfectScrollbar('.email-navigation');
	new PerfectScrollbar('.email-list');
</script>


@include('layouts.includes.datatable-js')
<script>
    $(document).ready(function() {
        $('#sale-item-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            ajax: '{{ route('sales.SaleItem.data', $saleItemId) }}',
            columns: [
                {
                    data: 'stock_item_name',
                    name: 'stock_item_name'
                },
                { data: 'gst_hsn_name', name: 'gst_hsn_name' },
                { data: 'billed_qty', name: 'billed_qty' },
                { 
                    data: 'rate', 
                    name: 'rate',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data + '/' + row.unit;  
                    }
                },
                { 
                    data: 'igst_rate', 
                    name: 'igst_rate',
                    render: function(data, type, row) {
                        return data ? data + '%' : '-';
                    }
                },
                { 
                    data: 'discount', 
                    name: 'discount',
                    render: function(data, type, row) {
                        return data ? data + '%' : '-';
                    }
                },
                { 
                    data: 'amount', 
                    name: 'amount',
                    className: 'text-end',
                    render: function(data, type, row) {
                        return data ? parseFloat(data).toFixed(2) : '0.00';
                    }
                }
            ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Helper function to parse and clean values
                    var intVal = function(i) {
                        return typeof i === 'string' ?
                            i.replace(/[\₹,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Calculate Subtotal
                    var subtotal = api
                        .column(6, { page: 'all' }) // Ensure to sum all pages
                        .data()
                        .reduce(function(a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Display Subtotal in the footer
                    $('#subtotal').text(subtotal.toFixed(2));
                    

                    // Get Round Off and IGST @18% from the HTML
                    var roundOff = parseFloat($('#roundOff').text().replace(/[\₹,]/g, '')) || 0;
                    var igst18 = parseFloat($('#igst18').text().replace(/[\₹,]/g, '')) || 0;

                    // Calculate Total Invoice Value
                    var totalInvoiceValue = subtotal + roundOff + igst18;

                    // Update Total Invoice Value in the footer
                    $('#totalInvoiceValue').text(totalInvoiceValue.toFixed(2));

                    $('#totalInvoiceAmount').text(totalInvoiceValue.toFixed(2));
                    $('#totalLedgerAmount').text(totalInvoiceValue.toFixed(2));
                }
        });
    });


</script>


@endpush
@section("script")
<script src="{{ url('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ url('assets/plugins/bs-stepper/js/main.js') }}"></script>

@endsection