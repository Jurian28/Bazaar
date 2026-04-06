<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_isRole_helper_returns_expected_values(): void
    {
        $user = User::factory()->create(['user_type' => User::TYPE_USER]);
        $this->assertTrue($user->isRole(User::TYPE_USER));
        $this->assertFalse($user->isRole(User::TYPE_SELLER));

        $seller = User::factory()->create(['user_type' => User::TYPE_SELLER]);
        $this->assertTrue($seller->isRole(User::TYPE_SELLER));
        $this->assertFalse($seller->isRole(User::TYPE_COMPANY));
    }
}
