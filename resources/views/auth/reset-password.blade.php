<x-guest-layout title="Login" bodyClass="page-login" :socialAuth="false">
    <h1 class="auth-page-title">Resetovanje Lozinke</h1>

    <form action="{{ route('password.update') }}" method="post">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group @error('email') has-error @enderror">
            <input type="email" readonly name="email" value="{{ request('email') }}"/>
            <div class="error-message">
                {{ $errors->first('email') }}
            </div>
        </div>

        <div class="form-group @error('password') has-error @enderror">
            <input type="password" placeholder="Nova Lozinka" name="password"/>
            <div class="error-message">
                {{ $errors->first('password') }}
            </div>
        </div>

        <div class="form-group">
            <input type="password" placeholder="Ponovite novu lozinku" name="password_confirmation"/>
        </div>

        <button class="btn btn-primary btn-login w-full">
            Reset
        </button>
    </form>
</x-guest-layout>
