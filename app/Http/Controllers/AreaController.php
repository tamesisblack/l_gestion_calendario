<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('id', 'desc')->get();
        return view('areas.index', compact('areas'));
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_area' => 'required|string|max:255',
        ]);

        Area::create($request->all());

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    public function show($id)
    {
        $area = Area::findOrFail($id);
        return view('areas.show', compact('area'));
    }

    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('areas.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_area' => 'required|string|max:255',
        ]);

        $area = Area::findOrFail($id);
        $area->update($request->all());

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
    public function getCordinadores($areaId)
    {
        $area = Area::with(['cordinadores' => function ($q) {
            $q->where('estado', 1);
        }])->findOrFail($areaId);

        return response()->json($area->cordinadores);
    }
}
