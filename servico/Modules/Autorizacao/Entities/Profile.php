<?php


namespace Modules\Autorizacao\Entities;


use Modules\Autorizacao\Services\CheckUserHasProfile;

class Profile implements CheckUserHasProfile
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function verify(Allowable $allowable): bool
    {
        return $this->getName() === $allowable->getProfileName();
    }
}