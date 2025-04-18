<x-guest-layout title="Login" bodyClass="page-login">
    <h1 class="auth-page-title">Login</h1>

    {{ session('error') }}

    <form action="{{ route('login.store') }}" method="post">
        @csrf
        <div class="form-group @error('email') has-error @enderror">
            <input type="email" placeholder="Email" name="email"
                   value="{{ old('email') }}"/>
            <div class="error-message">
                {{ $errors->first('email') }}
            </div>
        </div>
        <div class="form-group @error('password') has-error @enderror">
            <input type="password" placeholder="Lozinka" name="password"/>
            <div class="error-message">
                {{ $errors->first('password') }}
            </div>
        </div>
        <div class="text-right mb-medium">
            <a href="{{ route('password.request') }}"
               class="auth-page-password-reset">
                Zaboravili ste Lozinku?
            </a>
        </div>

        <button class="btn btn-primary btn-login w-full">Prijava</button>
    </form>

    <x-slot:footerLink>
        Nemate još nalog? -
        <a href="{{ route('signup') }}"> Kreirajte Nalog</a>
    </x-slot:footerLink>
</x-guest-layout>
