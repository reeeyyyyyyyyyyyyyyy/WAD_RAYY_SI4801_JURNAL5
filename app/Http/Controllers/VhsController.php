<?php

namespace App\Http\Controllers;

use App\Models\Vhs;
use App\Http\Resources\VhsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VhsController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data vhs
     */
    public function index()
    {
        // ambil semua data vhs
        $vhss = Vhs::all();

        // return koleksi vhs
        return VhsResource::colection($vhss);
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data vhs baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'director' => 'required|string|',
            'year' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'Please check your request',
                'errors' => $validator->errors()

            ], 422);
        }

        // Buat data vhs
        $vhs = Vhs::create($validator->validated());

        // return vhs yang dibuat sebagai resource
        return (new VhsResource($vhs))
                    ->additional(['message' => 'Vhs created successfully'])
                    ->response()
                    ->setStatusCode(201);

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data vhs berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data vhs berdasarkan ID
        // $vhs = ....

        if (!$vhs) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }

        // return vhs sebagai resource
        // return ....
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data vhs yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            
        ]);

        // Cari data vhs berdasarkan ID
        // $vhs = ....

        if (!$vhs) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                // 'errors' => ....
            ], 422);
        }

        // Update data vhs
        // $vhs->....

        // return vhs yang diupdate sebagai resource
        // return ....
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data vhs
     */
    public function destroy(string $id)
    {
        // Cari data vhs berdasarkan ID
        // $vhs = ....

        if (!$vhs) {
            return response()->json([
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }

        // Hapus data vhs
        // $vhs->....

        // return message sukses
        // return ....
    }
}
