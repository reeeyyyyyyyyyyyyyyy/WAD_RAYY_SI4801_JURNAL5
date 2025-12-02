<?php

namespace App\Http\Controllers;

use App\Models\Cassette;
use App\Http\Resources\CassetteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CassetteController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data cassette
     */
    public function index()
    {
        // ambil semua data cassette
        // $cassettes = ....

        // return koleksi cassette
        // return ....
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data cassette baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:225',
            'artist' => 'required|string',
            'year' => 'required|year',
        ]);

        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
                'massage' => 'please checkh your request',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buat data cassette
        // $cassette = ....
        $cassette = Cassette ::create($validator->validated());
        // return cassette yang dibuat sebagai resource
        // return ....
        return (new CassetteResource($cassette))
            ->additional(['massage' => 'cassette created succcesfully'])
            ->response()
            ->setstatuscode(201);
    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data cassette berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data cassette berdasarkan ID
        // $cassette = ....

        if (!$cassette) {
            return response()->json(['massage' => 'cassette not found'
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }

        // return cassette sebagai resource
        // return ....
        return new CassetteResource($cassette);
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data cassette yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, artist dan year
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:225',
            'artist' => 'sometimes|required|string',
            'year' => 'sometimes|time',
        ]);

        $cassette = Cassette::find($id);
        // Cari data cassette berdasarkan ID
        // $cassette = ....

        if (!$cassette) {
            return response()->json([
                'massage' => 'item not found'
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                'massage' => 'please chehck your request',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update data cassette
        // $cassette->....
        $cassette->update($validator->validated());
        // return cassette yang diupdate sebagai resource
        return (new CassetteResource($cassette))
            ->additional(['massage' => 'Cassette update succesfully'])
            ->response()
            ->setstatuscode(200);
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data cassette
     */
    public function destroy(string $id)
    {
        // Cari data cassette berdasarkan ID
        // $cassette = ....

        if (!$cassette) {
            return response()->json([
                // 'success' => false,
            'massage' => 'cassette not found'
            ], 404);
        }

        // Hapus data cassette
        // $cassette->....
        $cassette->delete();
        // return message sukses
        return response()->json(['massage' => 'cassette deleted succesfully'], 200);
    }
}
