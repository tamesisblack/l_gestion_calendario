<?php

namespace App\Http\Controllers;

use App\Models\CordinadorArea;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;

class CordinadorAreaController extends Controller
{
    public function index()
    {
        $cordinadores = CordinadorArea::with(['user', 'area'])
            ->join('users', 'cordinador_areas.user_id', '=', 'users.id')
            ->orderBy('users.nombres')
            ->select('cordinador_areas.*')
            ->get();
        return view('cordinadores.index', compact('cordinadores'));
    }

    public function create()
    {
        $usuarios = User::all();
        $areas = Area::all();
        return view('cordinadores.create', compact('usuarios', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'area_id' => 'required|exists:areas,id',
            'estado' => 'required|in:0,1',
        ]);

        CordinadorArea::create($request->all());

        return redirect()->route('cordinadores.index')->with('success', 'Coordinador asignado correctamente.');
    }

    public function edit($id)
    {
        $cordinador = CordinadorArea::findOrFail($id);
        $usuarios = User::all();
        $areas = Area::all();
        return view('cordinadores.edit', compact('cordinador', 'usuarios', 'areas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'area_id' => 'required|exists:areas,id',
            'estado' => 'required|in:0,1',
        ]);

        $cordinador = CordinadorArea::findOrFail($id);
        $cordinador->update($request->all());

        return redirect()->route('cordinadores.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cordinador = CordinadorArea::findOrFail($id);
        $cordinador->delete();

        return redirect()->route('cordinadores.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
