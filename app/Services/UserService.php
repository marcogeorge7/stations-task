<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store(array $userData): User
    {
        $user = User::query()->create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        return $user;
    }

    public function update(array $userData, User $user): User
    {
        $user->update([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        return $user;
        // Also, more actions with that user
    }
}
