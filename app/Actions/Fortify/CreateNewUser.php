<?php

namespace App\Actions\Fortify;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => [
                'required',
                'exists:roles,id',
                // Prevent self-registering as System Administrator.
                function ($attribute, $value, $fail) {
                    $role = Role::find($value);
                    if ($role && $role->slug === 'system-administrator') {
                        $fail('You cannot register as System Administrator.');
                    }
                },
            ],
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role_id' => $input['role_id'],
        ]);
    }
}