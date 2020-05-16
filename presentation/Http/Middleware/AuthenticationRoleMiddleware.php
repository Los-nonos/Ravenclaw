<?php


namespace Presentation\Http\Middleware;

use App\Exceptions\Forbidden;
use App\Exceptions\UnauthorizedException;
use Application\Services\TokenLogin\TokenLoginServiceInterface;
use Closure;
use Illuminate\Http\Request;

class AuthenticationRoleMiddleware
{
    private TokenLoginServiceInterface $tokenLoginService;

    public function __construct(TokenLoginServiceInterface $tokenLoginService)
    {
        $this->tokenLoginService = $tokenLoginService;
    }

    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @throws UnauthorizedException|Forbidden
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $hash = $request->header('token');

        if(!$hash)
        {
            throw new Forbidden("not hash provider");
        }

        if(!$this->tokenLoginService->exist($hash))
        {
            throw new Forbidden();
        }

        $token = $this->tokenLoginService->findByHash($hash);

        if($token->isExpired())
        {
            throw new UnauthorizedException("Token Expired");
        }

        $user = $token->getUser();

        if($user->isAdmin()) {
            foreach ($roles as $role){
                if($role == 'admin'){
                    $next($request);
                }
            }
            throw new UnauthorizedException("Unauthorized");
        }
        else if($user->isCustomer()) {
            foreach ($roles as $role){
                if($role == 'customer'){
                    $next($request);
                }
            }
            throw new UnauthorizedException("Unauthorized");
        }
        else {
            throw new UnauthorizedException("User has no role set");
        }
    }
}
