<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // get only the base64 after Basic
        $header = $request->header('Authorization');
        $header = explode(' ', $header)[1];

        $data = explode(':', base64_decode($header, true));
        if (count($data) !== 2) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        } else {
            $username = $data[0];
            $key = $data[1];

            $user = User::where('username', $username)->first();

            if ($user) {
                if ($user->apikey()->key == $key) {
                    return $next($request);
                }
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
