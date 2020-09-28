<?php

namespace App\Http\Controllers;

use App\Directorio;
use App\Http\Requests\CreateDirectorioRequest;
use App\Http\Requests\UpdateDirectorioRequest;
use Illuminate\Http\Request;

class DirectorioController extends Controller
{

    private function cargarArchivo($file)
    {
        $nombre_Archivo = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('fotografias'), $nombre_Archivo);
        return $nombre_Archivo;
    }

    // GET
    public function index(Request $request)
    {
        if($request->has('textoABuscar')){
            $contactos = Directorio::where('nombre','like','%'. $request->textoABuscar. '%')
            ->orWhere('telefono','like','%'. $request->textoABuscar. '%')->get();
            return $contactos;
        } else{
            $contactos = Directorio::all();
            return $contactos;
        }
    }

    //Post Insertar datos
    public function store(CreateDirectorioRequest $request)
    {
        $input = $request->all();
        if($request->has('foto'))
            $input['foto'] = $this->cargarArchivo($request->foto);
        Directorio::create($input);
        return response()->json([
            'res' => true,
            'message' => 'Registro creado correctamente'
        ],200);
    }

    // GET Obtener por id
    public function show(Directorio $directorio)
    {
        return $directorio;
    }

    //PUT Actualizar
    public function update(UpdateDirectorioRequest $request, Directorio $directorio)
    {
        $input = $request->all();
        if($request->has('foto'))
            $input['foto'] = $this->cargarArchivo($request->foto);
        $directorio->update($input);
        return response()->json([
            'res' => true,
            'message' => 'Registro actualizado correctamente'
        ],200);
    }

    //DELETE
    public function destroy(Directorio $directorio)
    {
        //$directorio->delete();
        Directorio::destroy([$directorio->getAttribute('id')]);
        return response()->json([
            'res' => true,
            'message' => 'Registro eliminado correctamente'
        ],200);
    }
}
