@extends("layouts.tenant")
@section('title', __('Items | Preciseca'))
@section("wrapper")
    <div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Item</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Items</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
      
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                  <div class="ms-auto">
                    {{-- <a href="{{ route('tenants.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New User</a> --}}
                    <form action="{{ route('items.fetchAndStore') }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-secondary radius-30 mt-2 mt-lg-0"><i class="bx bx-download"></i> Fetch</button>
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
@endpush