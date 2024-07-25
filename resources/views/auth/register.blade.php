<x-guest-layout>
    <!-- Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Estilos CSS para el asterisco rojo y el ojo -->
    <style>
        .required-field::after {
            content: '* Campo obligatorio';
            color: red;
        }

        .required-phone::after {
            content: '* Campo opcional';
            color: rgb(159, 152, 152);
        }

        h1 {
            font-size: 2.0rem;
        }

        .password-container {
            position: relative;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
        }

        .password-input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 70%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
        }
    </style>

    <!-- Función PHP para validar la cédula ecuatoriana -->
    <?php
    function validarCedulaEcuatoriana($cedula) {
        if (preg_match('/^[0-9]{10}$/', $cedula)) {
            $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
            $suma = 0;

            for ($i = 0; $i < 9; $i++) {
                $digito = (int)$cedula[$i] * $coeficientes[$i];
                $suma += ($digito >= 10) ? ($digito - 9) : $digito;
            }

            $verificador = 10 - ($suma % 10);
            $verificador = ($verificador == 10) ? 0 : $verificador;

            if ($verificador == (int)$cedula[9]) {
                return true;
            }
        }

        return false;
    }
    ?>

    <!-- Formulario de Registro -->
    <div class="container">
        <h1 class="text-center mt-4">Registro</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Identification -->
            <div class="mt-4">
                <x-input-label for="identification" :value="('Identification')" class="required-field" />
                <x-text-input id="identification" class="block mt-1 w-full" type="text" name="identification" :value="old('identification')" required autofocus minlength="8" maxlength="10" />
                <x-input-error :messages="$errors->get('identification')" class="mt-2" />
            </div>

            <!-- First Name -->
            <div class="mt-4">
                <x-input-label for="firstname" :value="('First Name')" class="required-field" />
                <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autocomplete="given-name" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>

            <!-- Second Name -->
            <div class="mt-4">
                <x-input-label for="secondname" :value="('Second Name')" class="required-field"/>
                <x-text-input id="secondname" class="block mt-1 w-full" type="text" name="secondname" :value="old('secondname')" required autocomplete="additional-name" />
                <x-input-error :messages="$errors->get('secondname')" class="mt-2" />
            </div>

            <!-- First Last Name -->
            <div class="mt-4">
                <x-input-label for="firstlastname" :value="('First Last Name')" class="required-field" />
                <x-text-input id="firstlastname" class="block mt-1 w-full" type="text" name="firstlastname" :value="old('firstlastname')" required autocomplete="family-name" />
                <x-input-error :messages="$errors->get('firstlastname')" class="mt-2" />
            </div>

            <!-- Second Last Name -->
            <div class="mt-4">
                <x-input-label for="secondlastname" :value="('Second Last Name')" class="required-field" />
                <x-text-input id="secondlastname" class="block mt-1 w-full" type="text" name="secondlastname" :value="old('secondlastname')" required autocomplete="additional-family-name" />
                <x-input-error :messages="$errors->get('secondlastname')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="('Email')" class="required-field" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone 1 -->
            <div class="mt-4">
                <x-input-label for="phone1" :value="('Phone 1')" class="required-field" />
                <x-text-input id="phone1" class="block mt-1 w-full" type="tel" name="phone1" :value="old('phone1')" required autocomplete="tel" pattern="\d{10}" title="El número de teléfono debe tener exactamente 10 dígitos." />
                <x-input-error :messages="$errors->get('phone1')" class="mt-2" />
            </div>

            <!-- Phone 2 -->
            <div class="mt-4">
                <x-input-label for="phone2" :value="('Phone 2')" class="required-phone"/>
                <x-text-input id="phone2" class="block mt-1 w-full" type="tel" name="phone2" :value="old('phone2')" pattern="\d{10}" title="El número de teléfono debe tener exactamente 10 dígitos." />
                <x-input-error :messages="$errors->get('phone2')" class="mt-2" />
            </div>

            <!-- Address -->
            <div class="mt-4">
                <x-input-label for="address" :value="('Address')" class="required-field" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="street-address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 password-container">
                <x-input-label for="password" :value="('Password')" class="required-field" />
                <x-text-input id="password" class="password-input block mt-1 w-full" type="password" name="password" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial." />
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4 password-container">
                <x-input-label for="password_confirmation" :value="('Confirm Password')" class="required-field" />
                <x-text-input id="password_confirmation" class="password-input block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" title="La contraseña debe tener al menos 8 caracteres, una letra mayúscula, un número y un carácter especial." />
                <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁️</span>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- reCAPTCHA -->
            <div class="mt-4">
                {!! htmlFormSnippet() !!}
                @if($errors->has('g-recaptcha-response'))
                    <div>
                        <small style="color: red;">{{ $errors->first('g-recaptcha-response') }}</small>
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            var passwordField = document.getElementById(id);
            var type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            // Update the icon
            var icon = document.querySelector(`#${id} + .toggle-password`);
            icon.textContent = type === 'password' ? '👁️' : '🙈';
        }
    </script>
</x-guest-layout>
