@extends("layouts.app")
@section('title', __('Dashboard | Preciseca'))
@section("style")
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
@endsection

@section("wrapper")
    <div class="page-wrapper">
            <div class="page-content">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                   <div class="col">
                     <div class="card radius-10 border-start border-0 border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Orders</p>
                                    <h4 class="my-1 text-info">4805</h4>
                                    <p class="mb-0 font-13">+2.5% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                     </div>
                   </div>
                   <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                       <div class="card-body">
                           <div class="d-flex align-items-center">
                               <div>
                                   <p class="mb-0 text-secondary">Total Revenue</p>
                                   <h4 class="my-1 text-danger">$84,245</h4>
                                   <p class="mb-0 font-13">+5.4% from last week</p>
                               </div>
                               <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-wallet'></i>
                               </div>
                           </div>
                       </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                       <div class="card-body">
                           <div class="d-flex align-items-center">
                               <div>
                                   <p class="mb-0 text-secondary">Bounce Rate</p>
                                   <h4 class="my-1 text-success">34.6%</h4>
                                   <p class="mb-0 font-13">-4.5% from last week</p>
                               </div>
                               <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                               </div>
                           </div>
                       </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                       <div class="card-body">
                           <div class="d-flex align-items-center">
                               <div>
                                   <p class="mb-0 text-secondary">Total Customers</p>
                                   <h4 class="my-1 text-warning">8.4K</h4>
                                   <p class="mb-0 font-13">+8.4% from last week</p>
                               </div>
                               <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
                               </div>
                           </div>
                       </div>
                    </div>
                  </div> 
                </div><!--end row-->


                        <div class="row row-cols-1 row-cols-md-1 row-cols-xl-2">
                            <div class="col">
                                <div class="card radius-10 border-start border-0 border-4 border-info">
                                    <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <h4 class="my-1 text-info">Accounting</h4>
                                                    <p class="mb-0 font-13">Get information about your accounting activities</p>
                                                </div>
                                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
                                                </div>
                                            </div>
                                            <div class="pt-4">
                                                <h5 class="my-1">Daybook</h5>
                                                <hr class="border-1">
                                                <h5 class="my-1">General Ledger</h5>
                                                <hr class="border-1">
                                                <h5 class="my-1">Cash and Bank</h5>
                                                <hr class="border-1">
                                                <h5 class="my-1">Payment Register</h5>
                                                <hr class="border-1">
                                                <h5 class="my-1">Receipt Register</h5>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            </div>
    </div>
@endsection

@section("script")
@endsection
