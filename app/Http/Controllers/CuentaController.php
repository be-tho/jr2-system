<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
    /**
     * Mostrar la página principal de cuenta
     */
    public function index()
    {
        $user = Auth::user();
        return view('sections.cuenta.index', compact('user'));
    }

    /**
     * Mostrar formulario de edición de perfil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('sections.cuenta.edit', compact('user'));
    }

    /**
     * Actualizar información del perfil
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $data = $request->validated();
        
        // Manejar subida de imagen de perfil
        if ($request->hasFile('profile_image')) {
            // Eliminar imagen anterior si existe
            if ($user->profile_image && $user->profile_image !== 'usuario.jpg') {
                Storage::disk('public')->delete('src/assets/images/' . $user->profile_image);
            }
            
            $image = $request->file('profile_image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/src/assets/images', $filename);
            $data['profile_image'] = $filename;
        }
        
        $user->update($data);
        
        return redirect()->route('cuenta.index')
            ->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Mostrar formulario de cambio de contraseña
     */
    public function changePassword()
    {
        return view('sections.cuenta.change-password');
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        
        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }
        
        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('cuenta.index')
            ->with('success', 'Contraseña actualizada correctamente');
    }


}
