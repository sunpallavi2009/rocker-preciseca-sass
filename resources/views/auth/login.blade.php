<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>

        <div class="wrapper">
            <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
                <div class="container">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                        <div class="col mx-auto">
                            <div class="card mb-0">
                                <div class="card-body">
                                    <div class="p-4">
                                        <div class="mb-3 text-center">
                                            <img src="assets/images/logo-icon.png" width="60" alt="" />
                                        </div>
                                        <div class="text-center mb-4">
                                            <h5 class="">Sign In</h5>
                                            <p class="mb-0">Please log in to your account</p>
                                        </div>

                                        <x-jet-validation-errors class="mb-4 text-danger" />
                                        @if (session('status'))
                                            <div class="mb-4 font-medium text-sm text-green-600 text-danger">
                                                {{ session('status') }}
                                            </div>
                                        @endif

                                        <div class="form-body">
                                            {{-- <form class="row g-3"> --}}
                                            <form class="row g-3" method="POST" action="{{ route('login') }}">
                                                    @csrf
                                                <div class="col-12">
                                                    <label for="inputEmailAddress" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="inputEmailAddress" placeholder="jhon@example.com" name="email" :value="old('email')" required >
                                                </div>
                                                <div class="col-12">
                                                    <label for="inputChoosePassword" class="form-label">Password</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" class="form-control border-end-0" name="password" required id="inputChoosePassword" value="12345678" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check form-switch">
                                                        {{-- <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"> --}}
                                                        <x-jet-checkbox class="form-check-input" id="remember_me" name="remember" />
                                                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                                    </div>
                                                </div>
                                                @if (Route::has('password.request'))
                                                    <div class="col-md-6 text-end"> <a href="{{ route('password.request') }}">Forgot Password ?</a>
                                                    </div>
                                                @endif
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="text-center ">
                                                        <p class="mb-0">Don't have an account yet? <a href="{{ route('register') }}">Sign up here</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>



    </x-jet-authentication-card>
</x-guest-layout>
