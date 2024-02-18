<?php

namespace App\Http\Middleware;

use App\Repository\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailExists
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->userRepository->getByEmail($request->input('email')))
            return response()->json([
                'message' => 'User with this email already exists'
            ], 400);

        return $next($request);
    }
}
