@extends("layouts.app")
@section('title', __('Customers | Preciseca'))
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
      
        <!--start email wrapper-->
        <div class="email-wrapper">
            <div class="email-sidebar">
                <div class="email-sidebar-header d-grid"> <a href="javascript:;" class="btn btn-info compose-mail-btn"><i class='bx bx-left-arrow-alt me-2'></i> <span class="ms-auto">7,513</span> Customers</a>
                </div>
                <div class="email-sidebar-content">
                    <div class="email-navigation" style="height: 530px;border-bottom: none;">
                        <div class="list-group list-group-flush"> <a href="app-emailbox.html" class="list-group-item active d-flex align-items-center"><i class='bx bxs-inbox me-3 font-20'></i><span>Inbox</span><span class="badge bg-primary rounded-pill ms-auto">7,513</span></a>
                            <a href="javascript:;" class="list-group-item d-flex align-items-center"><i class='bx bxs-star me-3 font-20'></i><span>Starred</span></a>
                            <a href="javascript:;" class="list-group-item d-flex align-items-center"><i class='bx bxs-alarm-snooze me-3 font-20'></i><span>Snoozed</span></a>
                            <a href="javascript:;" class="list-group-item d-flex align-items-center"><i class='bx bxs-send me-3 font-20'></i><span>Sent</span></a>
                            <a href="javascript:;" class="list-group-item d-flex align-items-center"><i class='bx bxs-file-blank me-3 font-20'></i><span>Drafts</span><span class="badge bg-primary rounded-pill ms-auto">4</span></a>
                            <a href="javascript:;" class="list-group-item d-flex align-items-center"><i class='bx bxs-bookmark me-3 font-20'></i><span>Important</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="email-header d-xl-flex align-items-center" style="height: auto;">
             

                    <div class="col-lg-12">
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h4 class="my-1 text-info">Customers</h4>
                                            <p class="mb-0 font-13"><i class='bx bxs-folder'></i> Sundry Debtors</p>
                                            <p class="mb-0 font-13"><i class='bx bxs-folder'></i> Overdue</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
                                        </div>
                                    </div>
                                    <div class="row p-2">
                                        <div class="col-lg-8" style="padding: 25px;background: #eee;border-bottom-left-radius: 15px;border-top-left-radius: 15px;">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <p class="mb-0 font-13">Total Invoices</p>
                                                    <h6>31</h6>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="mb-0 font-13">Total Invoices</p>
                                                    <h6>31</h6>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="mb-0 font-13">Total Invoices</p>
                                                    <h6>31</h6>
                                                </div>
                                                <div class="col-lg-3">
                                                    <p class="mb-0 font-13">Total Invoices</p>
                                                    <h6>31</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4" style="padding: 25px;background: #e7d9d9;border-bottom-right-radius: 15px;border-top-right-radius: 15px;">
                                            <div class="col-lg-3">
                                                <p class="mb-0 font-13">Total Invoices</p>
                                                <h6>31</h6>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

            </div>

            <div class="email-content">
                <div class="">
                    <div class="email-list">
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Wordpress</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">It is a long established fact that a reader will be distracted by the readable...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">5:56 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Locanto</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">The point of using Lorem Ipsum is that it has a more-or-less normal...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">5:45 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Facebook</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">There are many variations of passages of Lorem Ipsum available, majority suffered...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">4:32 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Alex Xender</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">4:25 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Alisha Mastana</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">4:18 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Synergy Technology</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">If you are going to use a passage of Lorem Ipsum, you need to be sure there...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">3:56 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Robina Consultant</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">3:43 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>HCl Technologies</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Bonorum et Malorum" by Cicero are also reproduced in their exact original form...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">2:25 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Tata India</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">But I must explain to you how all this mistaken idea of denouncing pleasure...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">2:14 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Jessica Jhons</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">At vero eos et accusamus et iusto odio dignissimos ducimus...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">1:30 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Anaxa Marvel</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">1:15 PM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Maxwell Linga</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">On the other hand, we denounce with righteous indignation and dislike...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">12:45 AM</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Cricket India</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Oct 25</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Start Sports Australia</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Excepteur sint occaecat cupidatat non proident, sunt in culpa...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Oct 22</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Diana Dating Services</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Oct 18</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Himalaya India</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Oct 10</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>NASA USA</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">All the Lorem Ipsum generators on the Internet tend to repeat predefined...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Sep 28</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Indeed Jobs</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Content here, content here', making it look like readable English...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Sep 22</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Wordfence</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Various versions have evolved over the years, sometimes by accident...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Sep 18</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>DocsApp India</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">But I must explain to you how all this mistaken idea of denouncing pleasure...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Sep 12</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Alex ReliableSoft</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Sep 02</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Ryan Robinson</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Business it will frequently occur that pleasures have to be repudiated...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Aug 22</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>TechGig Job Alert</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Aug 18</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1 bg-body">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Paytm India</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">All the Lorem Ipsum generators on the Internet tend to repeat predefined...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Jul 27</p>
                                </div>
                            </div>
                        </a>
                        <a href="app-emailread.html">
                            <div class="d-md-flex align-items-center email-message px-3 py-1">
                                <div class="d-flex align-items-center email-actions">
                                    <input class="form-check-input" type="checkbox" value="" /> <i class='bx bx-star font-20 mx-2 email-star'></i>
                                    <p class="mb-0"><b>Uber America</b>
                                    </p>
                                </div>
                                <div class="">
                                    <p class="mb-0">Chunks as necessary, making this the first true generator on the Internet...</p>
                                </div>
                                <div class="ms-auto">
                                    <p class="mb-0 email-time">Jul 24</p>
                                </div>
                            </div>
                        </a>
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

@endpush
@push('javascript')
<script>
	new PerfectScrollbar('.email-navigation');
	new PerfectScrollbar('.email-list');
</script>
@endpush