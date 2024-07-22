<div class="primary-menu">
  <nav class="navbar navbar-expand-lg align-items-center">
     <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
       <div class="offcanvas-header border-bottom">
           <div class="d-flex align-items-center">
               <div class="">
                   <img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
               </div>
               <div class="">
                   <h4 class="logo-text">Rocker</h4>
               </div>
           </div>
         <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
       </div>
       <div class="offcanvas-body">
         <ul class="navbar-nav align-items-center flex-grow-1">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title d-flex align-items-center">Dashboard</div>
                {{-- <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div> --}}
            </a>
          </li>
             <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                  <div class="parent-icon"><i class='bx bx-cube'></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Apps & Pages</div>
                  <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
              </a>
              <ul class="dropdown-menu">
                <li class="nav-item dropend">
                  <a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"><i class='bx bx-file'></i>Tenants</a>
                  <ul class="dropdown-menu submenu">
                      <li><a class="dropdown-item" href="{{ route('tenants.create') }}"><i class='bx bx-radio-circle'></i>Create Tenant</a></li>
                      <li><a class="dropdown-item" href="{{ route('tenants.index') }}"><i class='bx bx-radio-circle'></i>Tenant list</a></li>
                    </ul>
                </li>
                <li class="nav-item dropend">
                  <a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"><i class='bx bx-file'></i>Tally list</a>
                  <ul class="dropdown-menu submenu">
                      {{-- <li><a class="dropdown-item" href="{{ route('tally.index') }}"><i class='bx bx-radio-circle'></i>Group list</a></li>
                      <li><a class="dropdown-item" href="{{ route('jsonImport.ledger.show') }}"><i class='bx bx-radio-circle'></i>Ledger list</a></li>
                      <li><a class="dropdown-item" href="{{ route('jsonImport.otherledger.show') }}"><i class='bx bx-radio-circle'></i>Other Ledger list</a></li>
                      <li><a class="dropdown-item" href="{{ route('jsonImport.stockitem.show') }}"><i class='bx bx-radio-circle'></i>Stock Item list</a></li> --}}
                    </ul>
                </li>
              </ul>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('customers.index') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                  <div class="parent-icon"><i class='bx bx-user'></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Customers</div>
                  {{-- <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div> --}}
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('suppliers.index') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                  <div class="parent-icon"><i class='bx bx-user'></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Suppliers</div>
                  {{-- <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div> --}}
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('stock-items.index') ? 'active' : '' }}" href="{{ route('stock-items.index') }}">
                  <div class="parent-icon"><i class='bx bx-user'></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Stock Item</div>
                  {{-- <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div> --}}
              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ request()->routeIs('reports.index') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                  <div class="parent-icon"><i class='bx bx-calculator'></i>
                  </div>
                  <div class="menu-title d-flex align-items-center">Reports</div>
                  {{-- <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div> --}}
              </a>
            </li>
            
            <li class="nav-item dropdown d-none">
               <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                   <div class="parent-icon"><i class='bx bx-briefcase-alt'></i>
                   </div>
                   <div class="menu-title d-flex align-items-center">UI Elements</div>
                   <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
               </a>
               <ul class="dropdown-menu">
                 <li class="nav-item dropend">
                   <a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"><i class='bx bx-ghost'></i>Components</a>
                   <ul class="dropdown-menu scroll-menu">
                       {{-- <li><a class="dropdown-item" href="{{ url('component-navbar') }}"><i class='bx bx-radio-circle'></i>Navbar</a></li> --}}
                    </ul>
                 </li>
               </ul>
            </li>
             {{-- <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                   <div class="parent-icon"><i class='bx bx-line-chart'></i>
                   </div>
                   <div class="menu-title d-flex align-items-center">Charts</div>
                   <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
               </a>
               <ul class="dropdown-menu">
                 <li><a class="dropdown-item" href="{{ url('charts-apex-chart') }}"><i class='bx bx-bar-chart-alt-2' ></i>Apex</a></li>
                 <li><a class="dropdown-item" href="{{ url('charts-chartjs') }}"><i class='bx bx-line-chart'></i>Chartjs</a></li>
                 <li><a class="dropdown-item" href="{{ url('charts-highcharts') }}"><i class='bx bx-pie-chart-alt'></i>HighCharts</a></li>
                 <li class="nav-item dropend">
                   <a class="dropdown-item dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"><i class='bx bx-map-pin'></i>Maps</a>
                   <ul class="dropdown-menu submenu">
                       <li><a class="dropdown-item" href="{{ url('map-google-maps') }}"><i class='bx bx-radio-circle'></i>Google Maps</a></li>
                       <li><a class="dropdown-item" href="{{ url('map-vector-maps') }}"><i class='bx bx-radio-circle'></i>Vector Maps</a></li>
                    </ul>
                 </li>
               </ul>
             </li> --}}
             {{-- <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                   <div class="parent-icon"><i class="bx bx-grid-alt"></i>
                   </div>
                   <div class="menu-title d-flex align-items-center">Tables</div>
                   <div class="ms-auto dropy-icon"><i class='bx bx-chevron-down'></i></div>
               </a>
               <ul class="dropdown-menu">
                 <li><a class="dropdown-item" href="{{ url('table-basic-table') }}"><i class='bx bx-table'></i>Basic Table</a></li>
                 <li><a class="dropdown-item" href="{{ url('table-datatable') }}"><i class='bx bx-data' ></i>Data Table</a></li>
               </ul>
             </li> --}}
         </ul>
       </div>
     </div>
 </nav>
</div>