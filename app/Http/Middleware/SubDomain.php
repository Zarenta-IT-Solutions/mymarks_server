<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SubDomain
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
        if($request->session()->has('tenancy_db_name')) {
            \DB::disconnect('mysql');
            \Config::set('database.connections.mysql.database', $request->session()->get('tenancy_db_name'));
            \DB::reconnect();
            return $next($request);
        }else{
            flash('Selectt School First')->warning();
            return redirect('admin/school');
        }
    }
}
