<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Setting; 

class SettingsController extends Controller
{
    public function updateWelcomeView(Request $request)
    {
        $request->validate([
            'view_name' => 'required|string',
        ]);

        $viewName = $request->input('view_name');

        $allowedViews = ['welcome', 'welcome2', 'welcome3']; // AJUSTA ESTA LISTA SEGÚN TUS VISTAS

        if (in_array($viewName, $allowedViews) && View::exists($viewName)) {
            // Guardar en la base de datos usando el modelo Setting
            Setting::setValue('preferred_welcome_view', $viewName);

            return response()->json(['success' => true, 'message' => 'Vista de bienvenida actualizada y guardada permanentemente.']);
        }

        return response()->json(['success' => false, 'message' => 'Vista no válida o no encontrada.'], 400);
    }
}