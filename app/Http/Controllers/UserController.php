<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function getUserFirstName($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json(['firstname' => $user->firstname]);
        } else {
            return response()->json(['firstname' => 'Usuario Desconocido'], 404);
        }
    }
}