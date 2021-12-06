<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Role;


class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    //     $userRoles=Auth::guard('admin')->pageroles->plunk('role_id');
    //    dd($userRoles);
    //     if(!$userRoles->contains('Admin')){
    //         return redirect('/permission-denied');
    //     }
    //     return $next($request);
    // }
                if(!Auth::guard('page')->check()){
                        
                    return redirect('/home');
                }
                return $next($request);

}
// if(!Auth::guard('admin')->check()){
//     return redirect('/admin');
// }
// return $next($request);
// }
}
