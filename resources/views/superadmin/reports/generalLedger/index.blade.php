@extends("layouts.main")
@section('title', __('Reports | Preciseca'))
@section("style")
    <link href="{{ url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
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
                                        <li class="breadcrumb-item active" aria-current="page">General Ledger</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!--end breadcrumb-->

                        <div class="card">
                            <div class="card-body">
                                <div class="d-lg-flex align-items-center mb-4 gap-3">
                                    <div class="col-lg-2">
                                        <form id="dateRangeForm">
                                            <label for="date_range" class="form-label">Date Range</label>
                                            <input type="text" id="date_range" name="date_range" class="form-control date-range" placeholder="Select Date Range">
                                        </form>
                                    </div>
                                    <div class="col-lg-2">
                                        <form id="voucherTypeForm">
                                            <label for="voucher_type" class="form-label">Voucher Type</label>
                                            <select id="voucher_type" name="voucher_type" class="form-select">
                                                <option value="">All</option>
                                                <option value="Sales">Sale</option>
                                                <option value="Purchase">Purchase</option>
                                                <option value="Credit Note">CreditNote</option>
                                                <option value="Debit Note">DebitNote</option>
                                                <option value="Receipt">Receipt</option>
                                                <option value="Payment">Payment</option>
                                                {{-- <option value="JournalVoucher">JournalVoucher</option> --}}
                                                <!-- Add more options as needed -->
                                            </select>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    {{ $dataTable->table(['width' => '100%']) }}
                                </div>
                            </div>
                        </div>

            </div>
    </div>
@endsection

@push('css')
    @include('layouts.includes.datatable-css')
@endpush
@push('javascript')
    @include('layouts.includes.datatable-js')
    {!! $dataTable->scripts() !!}

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Initialize date range picker
        const dateRangeInput = document.querySelector(".date-range");
        flatpickr(dateRangeInput, {
            mode: "range",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length === 2) {
                    let [startDate, endDate] = selectedDates.map(date => date.toISOString().split('T')[0]);
                    let url = new URL(window.location.href);
                    url.searchParams.set('start_date', startDate);
                    url.searchParams.set('end_date', endDate);
                    window.location.href = url.toString();
                }
            }
        });

        // Handle voucher type filter
        const voucherTypeSelect = document.getElementById('voucher_type');
        voucherTypeSelect.addEventListener('change', function() {
            let voucherType = this.value;
            let url = new URL(window.location.href);
            url.searchParams.set('voucher_type', voucherType);
            window.location.href = url.toString();
        });

        // Reset filters on page load if needed
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const startDate = urlParams.get('start_date');
            const endDate = urlParams.get('end_date');
            const voucherType = urlParams.get('voucher_type');
            if (startDate && endDate) {
                dateRangeInput._flatpickr.setDate([startDate, endDate], false);
            }
            if (voucherType) {
                voucherTypeSelect.value = voucherType;
            }
        });
    </script>
@endpush