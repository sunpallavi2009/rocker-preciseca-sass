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
                        <li class="breadcrumb-item active" aria-current="page">General Ledger</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->


         <!--start email wrapper-->
         <div class="email-wrapper">
            <div class="email-sidebar">
                <div class="email-sidebar-header d-grid"> <a href="javascript:;" class="btn btn-primary compose-mail-btn"><i class='bx bx-left-arrow-alt me-2'></i> General Ledger</a>
                </div>
                <div class="email-sidebar-content">
                    <div class="email-navigation" style="height: 530px;">
                        <div class="list-group list-group-flush">
                            @foreach($menuItems as $item)
                                <a href="{{ route('reports.GeneralGroupLedger.details', ['GeneralLedger' => $item->id]) }}" class="list-group-item d-flex align-items-center {{ request()->route('GeneralLedger') == $item->id ? 'active' : '' }}" style="border-top: none;">
                                    <i class='bx {{ $item->icon ?? 'bx-default-icon' }} me-3 font-20'></i>
                                    <span>{{ $item->name }}</span>
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
                        <h4 class="my-1 text-info">{{ $generalLedger->name }} </h4>
                    </div>
                </div>

                {{-- <div class="col-lg-12">
                    <div class="col">
                        <div class="card radius-10 border-start border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <h4 class="my-1 text-info">{{ $generalLedger->name }} </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
               
            </div>
            
            <div class="email-content py-2">
                <div class="">
                    <div class="email-list">
                        <div class="table-responsive table-responsive-scroll  border-0">
                            <table class="table table-striped" id="general-group-ledger-table">
                                <thead>
                                    <tr>
                                        <td>Name</td>
                                        <td>Parent</td>
                                        <td>Opening Balance</td>
                                        <td>Debit</td>
                                        <td>Credit</td>
                                        <td>Closing Balance</td>
                                    </tr>
                                </thead>
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
        $('#general-group-ledger-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            ajax: '{{ route('reports.GeneralGroupLedger.data', $generalLedgerId) }}',
            columns: [
                {
                    data: 'language_name',
                    name: 'language_name'
                    // render: function(data, type, row) {
                    //     var url = '{{ route("reports.GeneralGroupLedger.details", ":id") }}';
                    //     url = url.replace(':id', row.id);
                    //     return '<a href="' + url + '" style="color: #337ab7;">' + data + '</a>';
                    // }
                },
                { data: 'parent', name: 'parent' },
                { data: 'parent', name: 'opening_balance' },
                { data: 'parent', name: 'debit' },
                { data: 'parent', name: 'credit' },
                { data: 'parent', name: 'closing_balance' }
            ]
        });
    });


</script>


@endpush
@section("script")
<script src="{{ url('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script src="{{ url('assets/plugins/bs-stepper/js/main.js') }}"></script>

@endsection