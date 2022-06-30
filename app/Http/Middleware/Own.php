<?php

namespace App\Http\Middleware;

use App\Models\Video;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Own
{
    /**
     * Create a new middleware instance.
     *
     * @return void
     *
     */
    public function __construct(Request $request)
    {
        $this->video = Video::find(base64_decode($request->video));
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->video->user_id == Auth::id()) {
            return $next($request);
        }
        return redirect()->route('home');
    }
}
