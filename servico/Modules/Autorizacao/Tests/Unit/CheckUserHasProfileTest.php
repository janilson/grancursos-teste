<?php

namespace Modules\Autorizacao\Tests\Unit;

use Modules\Autorizacao\Entities\Allowable;
use Modules\Autorizacao\Entities\Profile;
use Tests\TestCase;

class CheckProfileHasAuthorizationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_se_usuario_tem_o_perfil()
    {
        $mockUser = $this->mock(Allowable::class);
        $mockUser->allows()
            ->getProfileName()
            ->andReturns('I');
        $class = new Profile('I');

        $this->assertTrue($class->verify($mockUser));
    }

    public function test_se_usuario_nao_tem_o_perfil()
    {
        $mockUser = $this->mock(Allowable::class);
        $mockUser->allows()
            ->getProfileName()
            ->andReturns('E');
        $class = new Profile('I');

        $this->assertFalse($class->verify($mockUser));
    }
}
