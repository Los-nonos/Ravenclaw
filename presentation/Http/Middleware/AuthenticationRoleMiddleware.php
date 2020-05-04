<?php


namespace Presentation\Http\Middleware;

use Closure;
use Domain\Entities\User;
use Illuminate\Http\Request;

class AuthenticationRoleMiddleware
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     * @param array $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();
        if($user->isAdmin()) {
            foreach ($roles as $role){
                if($role == 'admin'){
                    $next($request);
                }
            }
            return $this->Unauthorized();
        }
        else if($user->isCustomer()) {
            foreach ($roles as $role){
                if($role == 'customer'){
                    $next($request);
                }
            }
            return $this->Unauthorized();
        }
        else {
            return $this->Unauthorized();
        }
    }

    private function Unauthorized(): array {
        return ['error' => 'unauthorized', 'statusCode' => '401'];
    }
}
