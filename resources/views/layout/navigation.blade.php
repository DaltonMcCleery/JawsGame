<nav class="navbar is-dark">
    <div class="navbar-brand">
        <a class="navbar-item" href="https://bulma.io">
            @include('svgs.logo')
        </a>
        <div class="navbar-burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="navbarExampleTransparentExample" class="navbar-menu">
        <div class="navbar-start"></div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                    <p class="control">
                        @auth
                            <a href="/profile" class="button is-danger" style="background-color: #e40403;">
                                <strong>Profile</strong>
                            </a>
                            <a href="/logout" class="button is-light">
                                Logout
                            </a>
                        @else
                            <a href="/register" class="button is-danger" style="background-color: #e40403;">
                                <strong>Sign up</strong>
                            </a>
                            <a href="/login" class="button is-light">
                                Log in
                            </a>
                        @endauth
                    </p>
                </div>
            </div>
        </div>
    </div>
</nav>
