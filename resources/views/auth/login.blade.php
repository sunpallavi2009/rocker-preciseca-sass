<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
        </x-slot>




{{-- 
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email Address') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="Enter Email Address"/>
            </div>

            <div class="mt-4">
                <div class="flex justify-between items-center">
                    <x-jet-label for="password" value="{{ __('Enter Password') }}" />
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="Enter password"/>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

           

            <div class="flex items-center justify-end mt-4">

                @if (Route::has('register'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        Don't have an account ? {{ __('Register here') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>

            </div>
        </form> --}}


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
                                            <h5 class="">Rocker Admin</h5>
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
                                        {{-- <div class="login-separater text-center mb-5"> <span>OR SIGN IN WITH</span>
                                            <hr/>
                                        </div> --}}
                                        {{-- <div class="list-inline contacts-social text-center">
                                            <a href="javascript:;" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i class="bx bxl-facebook"></i></a>
                                            <a href="javascript:;" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i class="bx bxl-twitter"></i></a>
                                            <a href="javascript:;" class="list-inline-item bg-google text-white border-0 rounded-3"><i class="bx bxl-google"></i></a>
                                            <a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i class="bx bxl-linkedin"></i></a>
                                        </div> --}}
    
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
