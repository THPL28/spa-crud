<?php
namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        return Material::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'marca' => 'required|string',
            'valor' => 'required|numeric',
        ]);

        return Material::create($data);
    }

    public function show($id)
    {
        return Material::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);
        $data = $request->validate([
            'nome' => 'required|string',
            'descricao' => 'required|string',
            'marca' => 'required|string',
            'valor' => 'required|numeric',
        ]);
        $material->update($data);

        return $material;
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();
        return response()->json(['success' => true]);
    }
}
