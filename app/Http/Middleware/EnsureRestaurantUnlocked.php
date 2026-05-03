<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRestaurantUnlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant = $request->route('restaurant');

        if (!$restaurant) {
            abort(404);
        }

        $restaurantModel = is_object($restaurant) ? $restaurant : \App\Models\Restaurant::find($restaurant);
        if (!$restaurantModel) {
            abort(404);
        }

        $restaurantId = $restaurantModel->id;
        
        $sessionKey = 'unlocked_restaurant_' . $restaurantId;

        // If admin has not validated or has locked it, clear pin session and block
        if ($restaurantModel->status !== 'unlocked') {
            $request->session()->forget($sessionKey);
            return redirect()
                ->route('mitra.restaurants.unlock.form', ['restaurant' => $restaurantId]);
        }

        if (!$request->session()->has($sessionKey) || $request->session()->get($sessionKey) !== true) {
            return redirect()
                ->route('mitra.restaurants.unlock.form', ['restaurant' => $restaurantId])
                ->withErrors(['pin' => 'Silakan masukkan PIN untuk mengelola restoran ini.']);
        }

        return $next($request);
    }
}
