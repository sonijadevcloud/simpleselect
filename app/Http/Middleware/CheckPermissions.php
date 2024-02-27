<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class CheckPermissions
{
    public function handle($request, Closure $next)
    {
        // Sprawdź, czy użytkownik jest zalogowany
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Pobierz rolę użytkownika
        $userRole = Auth::user()->roles()->first();

        // Pobierz nazwę ścieżki
        $routeName = $request->route()->getName();

        // Sprawdź, czy użytkownik ma wymagane uprawnienie dla danej ścieżki
        if ($userRole && $this->hasRequiredPermission($userRole, $routeName)) {
            return $next($request);
        }


        // Brak wymaganych uprawnień - przekieruj lub zwróć błąd
        abort(403, 'No appropriate permissions to view this content. Contact your administrator');
    }

    private function hasRequiredPermission($userRole, $routeName)
    {
        // Pobierz wszystkie uprawnienia przypisane do roli użytkownika
        $permissions = $userRole->abilities->pluck('name')->toArray();

        // Sprawdź, czy użytkownik ma przynajmniej jedno wymagane uprawnienie dla danej ścieżki
        if (strpos($routeName, 'users.') === 0) {
            $requiredPermissions = ['AdminUsers-R', 'AdminUsers-W', 'AdminUsers-D'];
        } elseif ($routeName == 'permissions.index') {
            $requiredPermissions = ['AdminPrivilege-R', 'AdminPrivilege-W', 'AdminPrivilege-D'];
        } elseif ($routeName == 'systemsettings.index') {
            $requiredPermissions = ['AdminSystemSettings-R', 'AdminSystemSettings-W', 'AdminSystemSettings-D'];
        } else {
            // Domyślnie brak uprawnień dla nieznanej ścieżki
            return false;
        }

        // Sprawdź, czy użytkownik ma przynajmniej jedno wymagane uprawnienie
        foreach ($requiredPermissions as $permission) {
            if (in_array($permission, $permissions)) {
                return true; // Użytkownik ma przynajmniej jedno wymagane uprawnienie
            }
        }

        return false; // Brak wymaganego uprawnienia dla danej ścieżki
    }

}
