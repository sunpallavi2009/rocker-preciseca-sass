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
                        <li class="breadcrumb-item active" aria-current="page">Voucher Head</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->


         <!--start email wrapper-->
         <div class="email-wrapper">
            <div class="email-sidebar">
                <div class="email-sidebar-header d-grid"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-left-arrow-alt me-2'></i> Voucher Head</a>
                </div>
                <div class="email-sidebar-content">
                    <div class="email-navigation" style="height: 530px;">
                        <div class="list-group list-group-flush">
                            @foreach($menuItems as $item)
                                <a href="{{ route('reports.VoucherHead', ['VoucherHead' => $item->guid]) }}" class="list-group-item d-flex align-items-center {{ request()->route('VoucherHead') == $item->guid ? 'active' : '' }}" style="border-top: none;">
                                    <i class='bx {{ $item->icon ?? 'bx-default-icon' }} me-3 font-20'></i>
                                    <span>{{ $item->language_name }}</span>
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
                        <h4 class="my-1 text-info">{{ $voucherHead->language_name }} </h4>
                    </div>
                </div>
               
            </div>
            
            <div class="email-content py-2">
                <div class="">
                    <div class="email-list">
                        <div class="table-responsive table-responsive-scroll  border-0">
                            <table class="table table-striped" id="voucher-head-table">
                                <thead>
                                    <tr>
                                        {{-- <td>Name</td> --}}
                                        <td>Date</td>
                                        <td>Transaction Type</td>
                                        <td>Transaction</td>
                                        <td>Debit</td>
                                        <td>Credit</td>
                                        <td>Running Balance</td>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Totals</th>
                                        <th colspan="2"></th>
                                        <th id="total-debit" style="text-align:right"></th>
                                        <th id="total-credit" style="text-align:right"></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
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
        $('#voucher-head-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            ajax: '{{ route('reports.VoucherHead.data', $voucherHeadId) }}',
            columns: [
                {
                    data: 'voucher_date',
                    name: 'voucher_date'
                },
                { data: 'voucher_type', name: 'voucher_type', className: 'text-center' },
                { data: 'voucher_number', name: 'voucher_number', className: 'text-center' },
                { data: 'debit', name: 'debit', className: 'text-end' },
                { data: 'credit', name: 'credit', className: 'text-end' },
                { data: 'running_balance', name: 'running_balance' }
            ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Function to parse numbers, handling non-numeric values
            var intVal = function (i) {
                return typeof i === 'string' ?
                    parseFloat(i.replace(/[\$,]/g, '')) || 0 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // Total over all pages
            var totalDebit = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            var totalCredit = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(3).footer()).html(
                totalDebit.toFixed(2)
            );
            $(api.column(4).footer()).html(
                totalCredit.toFixed(2)
            );
        }

        });
    });


</script>


@endpush
@section("script")
<script src="{{ url('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ url('assets/plugins/bs-stepper/js/main.js') }}"></script>

@endsection