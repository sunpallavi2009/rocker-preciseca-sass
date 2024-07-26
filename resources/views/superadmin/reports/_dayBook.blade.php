@extends("layouts.main")
@section('title', __('Reports | Preciseca'))
@section("style")
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
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
                                        <li class="breadcrumb-item active" aria-current="page">Daybook</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!--end breadcrumb-->

                        <div class="card">
                            <div class="card-body">
                                <div class="d-lg-flex align-items-center mb-4 gap-3">
                                    <div class="mb-3">
                                        <label class="form-label">Date Range</label>
                                        <input type="hidden" class="form-control date-range flatpickr-input" value="2024-07-01 to 2024-07-26"><input class="form-control date-range input active" placeholder="" tabindex="0" type="text" readonly="readonly">
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
@endpush