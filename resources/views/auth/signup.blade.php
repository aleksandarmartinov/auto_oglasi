<x-guest-layout title="Signup" bodyClass="page-signup">
    <h1 class="auth-page-title">Vaš Nalog</h1>

    <form action="{{ route('signup.store') }}" method="POST">
        @csrf
        <div class="form-group @error('name') has-error @enderror">
            <input type="text" placeholder="Vaše Ime" name="name"
                   value="{{ old('name') }}"/>
            <div class="error-message">
                {{ $errors->first('name') }}
            </div>
        </div>
        <div class="form-group @error('email') has-error @enderror">
            <input type="email" placeholder="Vaš Email" name="email"
                   value="{{ old('email') }}"/>
            <div class="error-message">
                {{ $errors->first('email') }}
            </div>
        </div>
        <div class="form-group @error('phone') has-error @enderror">
            <input type="text" placeholder="Broj Telefona" name="phone"
                   value="{{ old('phone') }}"/>
            <div class="error-message">
                {{ $errors->first('phone') }}
            </div>
        </div>
        <div class="form-group @error('password') has-error @enderror">
            <input type="password" placeholder="Lozinka" name="password"/>
            <div class="error-message">
                {{ $errors->first('password') }}
            </div>
        </div>
        <div class="form-group">
            <input type="password" placeholder="Ponovite Lozinku" name="password_confirmation"/>
        </div>
        <button class="btn btn-primary btn-login w-full">Kreiraj Nalog</button>
    </form>

    <x-slot:footerLink>
        Već imate nalog? -
        <a href="{{ route('login') }}"> Kliknite da se logujete </a>
    </x-slot:footerLink>
</x-guest-layout>
