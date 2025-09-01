<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CuentaController extends Controller
{
    use ImageHandler;

    // Configuración de imágenes para perfil
    private const IMAGE_DIRECTORY = 'src/assets/uploads/profile-images';
    private const DEFAULT_IMAGE = 'usuario.jpg';

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
            try {
                // Validar la imagen usando el trait ImageHandler
                $this->validateImage($request->file('profile_image'), [
                    'max_size' => config('images.profile.mobile.max_upload_size'),
                    'min_dimensions' => config('images.validation.min_dimensions'),
                    'max_dimensions' => config('images.validation.max_dimensions')
                ]);
                
                // Eliminar imagen anterior si existe y no es la imagen por defecto
                if ($user->profile_image && $user->profile_image !== self::DEFAULT_IMAGE) {
                    $this->deleteImage($user->profile_image, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
                
                // Procesar y guardar la imagen usando el trait ImageHandler
                $imageFilename = $this->processAndSaveImage(
                    $request->file('profile_image'),
                    self::IMAGE_DIRECTORY,
                    config('images.profile.options')
                );
                
                if ($imageFilename) {
                    // Actualizar el campo en la base de datos
                    $data['profile_image'] = $imageFilename;
                    
                    \Log::info('Imagen de perfil actualizada para usuario: ' . $user->email . ' - Archivo: ' . $imageFilename);
                } else {
                    throw new \Exception('No se pudo procesar la imagen');
                }
                
            } catch (\Exception $e) {
                \Log::error('Error al subir imagen de perfil: ' . $e->getMessage());
                
                return back()
                    ->withInput($request->except('profile_image'))
                    ->withErrors(['profile_image' => 'Error al procesar la imagen: ' . $e->getMessage()]);
            }
        }
        
        // Actualizar usuario
        $user->update($data);
        
        $message = 'Perfil actualizado correctamente';
        if ($request->hasFile('profile_image')) {
            $message = 'Perfil e imagen de perfil actualizados correctamente';
        }
        
        return redirect()->route('cuenta.index')
            ->with('success', $message);
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
        
        try {
            // Verificar contraseña actual
            if (!Hash::check($request->current_password, $user->password)) {
                \Log::warning('Intento fallido de cambio de contraseña para usuario: ' . $user->email . ' - Contraseña actual incorrecta');
                
                return back()
                    ->withInput($request->only('password', 'password_confirmation'))
                    ->withErrors(['current_password' => 'La contraseña actual es incorrecta. Por favor, verifica e intenta nuevamente.']);
            }
            
            // Verificar que la nueva contraseña sea diferente a la actual
            if (Hash::check($request->password, $user->password)) {
                return back()
                    ->withInput($request->only('password', 'password_confirmation'))
                    ->withErrors(['password' => 'La nueva contraseña debe ser diferente a la contraseña actual.']);
            }
            
            // Actualizar contraseña
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            // Log de seguridad
            \Log::info('Usuario ' . $user->email . ' cambió su contraseña exitosamente desde IP: ' . $request->ip());
            
            // Cerrar sesión en otros dispositivos (opcional, para mayor seguridad)
            // Auth::logoutOtherDevices($request->current_password);
            
            return redirect()->route('cuenta.index')
                ->with('success', '¡Contraseña actualizada correctamente! Tu nueva contraseña ya está activa. Por seguridad, se recomienda cerrar sesión en otros dispositivos.');
                
        } catch (\Exception $e) {
            \Log::error('Error al actualizar contraseña para usuario ' . $user->email . ': ' . $e->getMessage());
            
            return back()
                ->withInput($request->only('password', 'password_confirmation'))
                ->withErrors(['password' => 'Ocurrió un error al actualizar la contraseña. Por favor, intenta nuevamente. Si el problema persiste, contacta al administrador.']);
        }
    }
}
