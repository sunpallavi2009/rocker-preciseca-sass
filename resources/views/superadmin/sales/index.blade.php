@extends("layouts.main")
@section('title', __('Invoices | Preciseca'))
@section("style")
    <link href="{{ url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
@endsection

@section("wrapper")
    <div class="page-wrapper">
            <div class="page-content">
                        <!--breadcrumb-->
                        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                            <div class="breadcrumb-title pe-3">Invoices</div>
                            <div class="ps-3">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 p-0">
                                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Invoices</li>
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
        // Function to get the date X days ago
        function getDateXDaysAgo(days) {
            const date = new Date();
            date.setDate(date.getDate() - days);
            return date;
        }

        // Default dates: last 30 days
        const endDate = new Date();
        const startDate = getDateXDaysAgo(30);

        // Initialize date range picker
        const dateRangeInput = document.querySelector(".date-range");
        flatpickr(dateRangeInput, {
            mode: "range",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            defaultDate: [startDate, endDate],
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

        // Set default date range on page load if not set
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.get('start_date') || !urlParams.get('end_date')) {
                let url = new URL(window.location.href);
                url.searchParams.set('start_date', startDate.toISOString().split('T')[0]);
                url.searchParams.set('end_date', endDate.toISOString().split('T')[0]);
                window.location.href = url.toString();
            }
        });
    </script>
    {{-- <script>
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

        // Reset filters on page load if needed
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const startDate = urlParams.get('start_date');
            const endDate = urlParams.get('end_date');
            if (startDate && endDate) {
                dateRangeInput._flatpickr.setDate([startDate, endDate], false);
            }
        });
    </script> --}}
@endpush