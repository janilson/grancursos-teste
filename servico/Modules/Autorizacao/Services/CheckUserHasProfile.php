<?php


namespace Modules\Autorizacao\Services;


use Modules\Autorizacao\Entities\Allowable;

interface CheckUserHasProfile
{
    public function verify(Allowable $allowable): bool ;
}