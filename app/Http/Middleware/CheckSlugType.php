<?php

namespace App\Http\Middleware;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Product;
use App\Models\Page;
use App\Models\Category;

class CheckSlugType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        $guessClasses = [
            Page::class => PageController::class,
            Product::class => ProductController::class,
            Category::class => CategoryController::class,
        ];

        $trovato = false;
        foreach ($guessClasses as $classModelName => $classControllerName) {
            if ($entity = $classModelName::where('slug', $slug)->first()) {
                $request->route()->setAction([
                    'uses' => "{$classControllerName}@show",
                    //'controller' => "{$classControllerName}@show",
                ]);
                $request->route()->setParameter('slug', $entity);
                //$request->route()->setParameter('product', $product);
                $trovato = true;
                break;
            }
        }

        if ($trovato) {
            return $next($request);
        } else {
            abort(404);
        }
    }
}
