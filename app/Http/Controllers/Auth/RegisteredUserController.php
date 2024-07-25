<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Asegúrate de importar el modelo Role
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos de la solicitud
        $request->validate([
            'identification' => ['required', 'string', 'size:10', 'unique:users'],
            'firstname' => ['required', 'string', 'max:255'],
            'secondname' => ['nullable', 'string', 'max:255'],
            'firstlastname' => ['required', 'string', 'max:255'],
            'secondlastname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone1' => ['required', 'string', 'max:255'],
            'phone2' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'g-recaptcha-response' => ['required', 'recaptcha'],
        ]);

        // Crear el usuario
        $user = User::create([
            'identification' => $request->identification,
            'firstname' => $request->firstname,
            'secondname' => $request->secondname,
            'firstlastname' => $request->firstlastname,
            'secondlastname' => $request->secondlastname,
            'email' => $request->email,
            'phone1' => $request->phone1,
            'phone2' => $request->phone2,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // Asignar rol al usuario
        $role = Role::where('rol_name', 'user')->first(); // Buscar el rol 'user'
        if ($role) {
            $user->rol_id = $role->id;
            $user->save();
        }

        // Disparar el evento de registro
        event(new Registered($user));

        // Autenticar al usuario
        Auth::login($user);

        // Redirigir al usuario al dashboard
        return redirect()->route('dashboard');
    }
}
