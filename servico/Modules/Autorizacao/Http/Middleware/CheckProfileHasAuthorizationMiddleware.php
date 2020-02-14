<?php

namespace Modules\Autorizacao\Http\Middleware;

use App\Exceptions\ForbidenException;
use Closure;
use Illuminate\Http\Request;
use Modules\Autorizacao\Entities\Allowable;
use Modules\Autorizacao\Entities\Profile;

class CheckProfileHasAuthorizationMiddleware
{

    /**
     * @var Allowable
     */
    private $allowable;

    public function __construct(Allowable $allowable)
    {
        $this->allowable = $allowable;
    }

    public function handle(Request $request, Closure $next, $profile)
    {

        if (!(new Profile($profile))->verify($this->allowable)) {
            throw new ForbidenException();
        }

        return $next($request);
    }
}
