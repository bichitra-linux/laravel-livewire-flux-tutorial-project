<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\RequirePassword;

class RequirePasswordConfirmation extends RequirePassword
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @param \Closure $next
     * @param string|null  $redirectToRoute
     * @param string|int|null $passwordTimeoutSeconds
     * @return mixed
     */

    public function handle($request, Closure $next, $redirectToRoute = null, $passwordTimeoutSeconds = null){

        if($this->shouldConfirmPassword($request, $passwordTimeoutSeconds)){
            if ($request->expectsJson()){
                return $this->responseFactory->json([
                    'message' => 'Password confirmation required.'
                ], 423);
            }

            $route = $this->getPasswordConfirmationRoute();

            return $this->responseFactory->redirectGuest(
                $this->urlGenerator->route($route)
            );
        }

        return $next($request);
    }


    /**
     * Get the password confirmation route name based on user role.
     * @return string
     */

    protected function getPasswordConfirmationRoute(): string{
        $user = auth()->user();
        if ($user && $user->hasRole(['admin', 'editor', 'writer'])) {
            return 'admin.password.confirm.store';
        }
        return 'user.password.confirm.store';
    }
}
