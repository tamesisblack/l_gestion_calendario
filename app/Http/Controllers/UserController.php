<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Método para mostrar el listado de usuarios
    public function index()
    {
        // Obtener todos los usuarios con su relación de roles
        $usuarios = User::with('role')->get();
        // Devolver la vista con los usuarios listados
        return view('usuarios.index', compact('usuarios'));
    }

    // Método para mostrar la vista de creación de un nuevo usuario
    public function create()
    {
        // Obtener todos los roles para mostrarlos en un combo seleccionable
        $roles = Role::all();
        // Devolver la vista de creación de usuarios con los roles disponibles
        return view('usuarios.create', compact('roles'));
    }

    // Método para almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255', // Nombres requeridos
            'apellidos' => 'required|string|max:255', // Apellidos requeridos
            'telefono' => 'required|string|max:15', // Teléfono requerido
            'email' => 'required|string|email|max:255|unique:users', // Email único requerido
            'rol_id' => 'required|integer', // Rol requerido
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Foto opcional
        ]);

        // Almacenar la foto si fue proporcionada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public'); // Almacena la foto en el sistema de archivos
        }

        // Creación del nuevo usuario con los datos validados
        User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'password' => Hash::make('password'), // Se establece una contraseña predeterminada
            'foto' => $fotoPath,
        ]);

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Registro Creado Correctamente');
    }

    // Método para mostrar el formulario de edición de un usuario
    public function edit($id)
    {
        // Encontrar el usuario por su ID
        $usuario = User::findOrFail($id);
        // Obtener todos los roles disponibles
        $roles = Role::all();
        // Devolver la vista de edición con los datos del usuario y los roles
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    // Método para actualizar los datos de un usuario en la base de datos
    public function update(Request $request, $id)
    {
        // Validación de los datos recibidos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Permite el mismo email para el usuario actual
            'rol_id' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Encontrar el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar la foto si fue proporcionada
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
            $usuario->foto = $fotoPath;
        }

        // Actualización de los datos del usuario
        $usuario->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
        ]);

        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Registro Actualizado Correctamente');
    }

    // Método para eliminar un usuario de la base de datos
    public function destroy($id)
    {
        // Encontrar el usuario por su ID
        $usuario = User::findOrFail($id);
        // Eliminar el usuario
        $usuario->delete();
        // Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Registro Eliminado Correctamente');
    }
}
