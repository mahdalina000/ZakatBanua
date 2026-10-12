<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Batasi akses hanya untuk user dengan role pengelola (admin).
 *
 * Role pengelola: super_admin, admin_baznas, admin_upz, admin.
 * Kontrak: openapi.yaml#/components/responses/ForbiddenError
 */
class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden. Hanya admin yang dapat mengakses.',
            ], 403);
        }

        if (! $user->is_active) {
            return response()->json([
                'message' => 'Akun Anda dinonaktifkan.',
            ], 403);
        }

        return $next($request);
    }
}