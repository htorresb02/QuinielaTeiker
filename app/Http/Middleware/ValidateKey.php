<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User; // Importar modelo User

class ValidateKey
{
    public function handle(Request $request, Closure $next)
    {
        // Validar si la clave única está presente en el request
        $uniqueKey = $request->input('unique_key');

        if (!$uniqueKey || !User::where('unique_key', $uniqueKey)->exists()) {
            return redirect()->route('quiniela.form')->with('error', 'Clave única inválida. Inténtalo de nuevo.');
        }

        return $next($request);
    }
}