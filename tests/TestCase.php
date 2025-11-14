<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function authenticate(): array
    {
        $user  = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        return [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
    }
}
