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
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('slug');

        $guessClasses = [
            Page::class => [PageController::class, 'show'],
            Product::class => [ProductController::class, 'show'],
            Category::class => [CategoryController::class, 'show'],
        ];

        $trovato = false;
        foreach ($guessClasses as $classModelName => [$classControllerName, $classMethodName]) {
            if ($entity = $classModelName::where('slug', $slug)->first()) {
                $request->route()->setAction([
                    'uses' => "{$classControllerName}@{$classMethodName}",
                    //'controller' => "{$classControllerName}@{$classMethodName}",
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
