<?php

namespace App\Http\Controllers;

use App\Models\Bluray;
use App\Http\Resources\BlurayResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlurayController extends Controller
{
    
    public function index()
    {
        $blurays = Bluray::all();
    return BlurayResource::collection($blurays);
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data bluray baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title' =>'required|string|max:255',
            'artist' =>'nullable|string',
            'year' =>'required|integer|min:0',
            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please check your request',
                'errors' => $validator->errors()
            ], 422);
        }

        $bluray = Bluray::create($validator->validated());

        return (new BlurayResource($bluray))
                    ->additional(['message' => 'Item created successfully'])
                    ->response()
                    ->setStatusCode(201);
        
    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data bluray berdasarkan ID
     */
    public function show(string $id)
    {
        $bluray = Bluray::find($id);

        if (!$bluray) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }

        // return bluray sebagai resource
        // return ....
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data bluray yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'artist' => 'sometimes|nullable|string',
            'year' => 'sometimes|required|integer|min:0',
        ]);

        // Cari data bluray berdasarkan ID
        // $bluray = ....

        $bluray = Bluray::find(($id));
        if (!$bluray) {
            return response()->json([
                'success' => false,
                'message' => 'not found'
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }   
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data bluray
     */
    public function destroy(string $id)
    {
        // Cari data bluray berdasarkan ID
        // $bluray = ....
        $bluray = Bluray::find($id);
        if (!$bluray) { 
            return response()->json(['message' => 'Bluray not found'], 404);

        }
        
        $bluray->delete();

        return response()->json(['message' => 'Bluray deleted successfully'], 200);
        // Hapus data bluray
        // $bluray->....

        // return message sukses
        // return ....
    }
}
