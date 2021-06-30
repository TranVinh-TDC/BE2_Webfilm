<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;

class VerifyCategoriesCount
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
        if(Category::All()->count() == 0)
        {
            session()->flash('error', 'You need to add categories to be able to create a film');

            return redirect(route('categories.index'));
        }
        return $next($request);
    }
}
