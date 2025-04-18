<x-app-layout>
    <main>
        <div class="container-small">
            <h1 class="car-details-page-title">Moj Profil</h1>

            {{-- Update User Form --}}
            <form action="{{ route('profile.update') }}" method="POST"
                  class="card p-large my-large">
                @csrf
                @method('PUT')

                <div class="form-group @error('name') has-error @enderror">
                    <label>Ime</label>
                    <input type="text" name="name" placeholder="Vaše Ime"
                           value="{{ old('name', $user->name) }}">
                    <p class="error-message">
                        {{ $errors->first('name') }}
                    </p>
                </div>

                <div class="form-group @error('email') has-error @enderror">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="Vaš Email"
                           value="{{ old('email', $user->email) }}"
                           @disabled($user->isOauthUser())> {{-- disabled ako se sign in putem fb ili googla --}}
                    <p class="error-message">
                        {{ $errors->first('email') }}
                    </p>
                </div>

                <div class="form-group @error('phone') has-error @enderror">
                    <label>Telefon</label>
                    <input type="text" name="phone" placeholder="Vaš telefon"
                           value="{{ old('phone', $user->phone) }}">
                    <p class="error-message">
                        {{ $errors->first('phone') }}
                    </p>
                </div>

                <div class="p-medium">
                    <div class="flex justify-end gap-1">
                        <button class="btn btn-primary">Izmenite Profil</button>
                    </div>
                </div>
            </form>

            {{-- Update Password Form --}}
            <form action="{{ route('profile.updatePassword') }}" method="POST"
                  class="card p-large my-large">
                @csrf
                @method('PUT')

                <div class="form-group @error('current_password') has-error @enderror">
                    <label>Trenutna Lozinka</label>
                    <input type="password" name="current_password" placeholder="Trenutna Lozinka">
                    <p class="error-message">
                        {{ $errors->first('current_password') }}
                    </p>
                </div>
                <div class="form-group @error('password') has-error @enderror">
                    <label>Nova Lozinka</label>
                    <input type="password" name="password" placeholder="Nova Lozinka">
                    <p class="error-message">
                        {{ $errors->first('password') }}
                    </p>
                </div>
                <div class="form-group">
                    <label>Ponovite Lozinku</label>
                    <input type="password" name="password_confirmation" placeholder="Ponovite Lozinku">
                </div>

                <div class="p-medium">
                    <div class="flex justify-end gap-1">
                        <button class="btn btn-primary">Izmenite Lozinku</button>
                    </div>
                </div>
            </form>

        </div>
    </main>
</x-app-layout>
