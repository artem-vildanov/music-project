<?php

namespace App\Http\Middleware;

use App\Exceptions\JwtException;
use App\Facades\AuthFacade;
use App\Models\TokenPayloadModel;
use App\Services\TokenService;
use App\Services\EncodeDecodeService;
use App\Services\TokenStorageService;
use Closure;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class AuthInfoMiddleware
{
    public function __construct(
        private readonly TokenService        $tokenService,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authInfo = $this->getAuthInfo($request);
        $request->attributes->add(['authInfo' => $authInfo]);

        return $next($request);
    }

    private function getAuthInfo(Request $request): ?TokenPayloadModel
    {
        try {
            $token = $this->tokenService->getTokenFromRequest($request);
            $tokenPayload = $this->tokenService->getTokenPayload($token);
        } catch (JwtException $exception) {
            return null;
        }

        return $tokenPayload;
    }
}
