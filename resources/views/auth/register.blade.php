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
                                    Register to Play!
                                </p>
                            </header>

                            <div class="card-content">
                                <div class="content">
                                    <form method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">
                                        @csrf

                                        {{-- NAME--}}
                                        <div class="field">
                                            <label class="label">Name <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('name') ? ' is-danger' : '' }}"
                                                       type="text" name="name" value="{{ old('name') }}" required autofocus>
                                            </div>
                                            @if ($errors->has('name'))
                                                <p class="help is-danger">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        {{-- USERNAME --}}
                                        <div class="field">
                                            <label class="label">Username <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('username') ? ' is-danger' : '' }}"
                                                       type="text" name="username" value="{{ old('username') }}"
                                                       placeholder="Username" required>
                                            </div>
                                            @if ($errors->has('username'))
                                                <p class="help is-danger">{{ $errors->first('username') }}</p>
                                            @endif
                                        </div>

                                        {{-- EMAIL --}}
                                        <div class="field">
                                            <label class="label">Email <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('email') ? ' is-danger' : '' }}"
                                                       type="text" name="email" value="{{ old('email') }}"
                                                       placeholder="Email" required>
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

                                        {{-- CONFIRM PASSWORD --}}
                                        <div class="field">
                                            <label class="label">Confirm Password <span style="color: #e40403;">*</span></label>
                                            <div class="control">
                                                <input class="input {{ $errors->has('password_confirmation') ? ' is-danger' : '' }}"
                                                       type="password" name="password_confirmation" placeholder="Confirm Password" required>
                                            </div>
                                            @if ($errors->has('password_confirmation'))
                                                <p class="help is-danger">{{ $errors->first('password_confirmation') }}</p>
                                            @endif
                                        </div>

                                        <div class="field is-grouped is-align-items-center mt-4">
                                            <div class="control">
                                                <button class="button is-success">Submit</button>
                                            </div>
                                            <div class="control">
                                                <a href="{{ route('login') }}">
                                                    Login to existing Ninja Account
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
