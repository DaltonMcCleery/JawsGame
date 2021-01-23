<form wire:submit.prevent="save">
    @csrf

    @if (session()->has('message'))
        <section class="hero is-success mb-4">
            <div class="hero-body" style="text-align: center">
                <div class="container">
                    <h2 class="subtitle">
                        {{ session('message') }}
                    </h2>
                </div>
            </div>
        </section>
    @endif

    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input @error('user.name') is-danger @enderror" type="text"
                   placeholder="Name" wire:model="user.name">
        </div>
        @error('user.name')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Username</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input @error('user.username') is-danger @enderror" type="text"
                   placeholder="Username" wire:model="user.username">
            <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
            </span>
        </div>
        @error('user.username')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label">Email</label>
        <div class="control has-icons-left has-icons-right">
            <input class="input @error('user.email') is-danger @enderror" type="email"
                   placeholder="Email" wire:model="user.email">
            <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
            </span>
        </div>
        @error('user.email')
            <p class="help is-danger">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <div class="control">
            <button type="submit" class="button is-success">Save</button>
        </div>
    </div>
</form>
