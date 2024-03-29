<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('userId') || Session::has('userId') == null || !Session::has('roleIdentity')) {
            return redirect()->route('logOut');
        } else {
            $user = User::findOrFail(currentUserId());
            app()->setLocale($user->language);
            if (!$user) {
                return redirect()->route('logOut');
            } else if (currentUser() != 'superadmin') {
                return redirect()->back()->with('error','Access Denied');
            } else {
                return $next($request);
            }
        }
        return redirect()->route('logOut');
    }
}
