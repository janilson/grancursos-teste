<?php


namespace Modules\Autorizacao\Entities;


interface Allowable
{
    public function getProfileName(): ?string;
}