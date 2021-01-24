@extends('wrapper')

@section('content')

    <section class="hero is-medium is-dark">
        <div class="hero-body">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">

                            <header class="card-header">
                                <p class="card-header-title is-centered">
                                    Login to your existing Account
                                </p>
                            </header>

                            <div class="card-content">
                                <div class="content">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        {{-- EMAIL --}}
                                        <div class="field">
                                            <label class="label">Email <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}"
                                                       type="text" name="email" value="{{ old('email') }}"
                                                       placeholder="Email" required autofocus>
                                            </div>
                                            @if ($errors->has('email'))
                                                <p class="help is-danger">{{ $errors->first('email') }}</p>
                                            @endif
                                        </div>

                                        {{-- PASSWORD --}}
                                        <div class="field">
                                            <label class="label">Password <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('password') ? ' is-danger' : '' }}"
                                                       type="password" name="password" placeholder="Password" required>
                                            </div>
                                            @if ($errors->has('password'))
                                                <p class="help is-danger">{{ $errors->first('password') }}</p>
                                            @endif
                                        </div>

                                        <div class="field is-grouped is-align-items-center mt-4">
                                            <div class="control">
                                                <button class="button is-success">Login</button>
                                            </div>
                                            <div class="control">
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    Forgot Your Password?
                                                </a>
                                            </div>
                                        </div>

                                        <div class="field is-grouped is-align-items-center mt-2">
                                            <div class="control">
                                                <a href="{{ route('register') }}">
                                                    Create an Account
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

