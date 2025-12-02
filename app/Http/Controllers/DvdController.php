<?php

namespace App\Http\Controllers;

use App\Models\Dvd;
use App\Http\Resources\DvdResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DvdController extends Controller
{
    /**
     * ===========1================
     * Buat fungsi index yang mengembalikan semua data dvd
     */

    public function index()
    {
        // ambil semua data dvd
        // $dvds = ....
      $dvd = dvd::all();
      return DvdResource::collection($dvd);
        // return koleksi dvd
        // return ....
    }

    /**
     * ===========2================
     * Buat fungsi store untuk menambahkan data dvd baru
     */
    public function store(Request $request)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'artist' => 'nullable|string',
            'year' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                // 'success' => false,
                    'message' => 'Please Check your request',
                    'errors' => $validator->errors()
                // 'errors' => ....
            ], 422);
        }

        // Buat data dvd
        // $dvd = ....
        $dvd = Dvd::create($validator->validated());

        return (new dvdResource($dvd))
                ->additional(['message' => 'dvd created successfully'])
                ->response()
                ->setStatus(201);
        // return dvd yang dibuat sebagai resource
        // return ....

    }

    /**
     * ===========3================
     * Buat fungsi show untuk menampilkan satu data dvd berdasarkan ID
     */
    public function show(string $id)
    {
        // Cari data dvd berdasarkan ID
        // $dvd = ....

        if (!$dvd) {
            return response()->json([
                'message' => 'item not found'
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }
          return new itemResource($dvd);
        // return dvd sebagai resource
        // return ....
    }

    /**
     * ===========4================
     * Buat fungsi update untuk mengubah data dvd yang ada
     */
    public function update(Request $request, string $id)
    {
        // Request body berisi title, director dan year
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'artist' => 'sometimes|nullable|string',
            'year' => 'sometimes|required|year|min:0',
            
        ]);
          $dvd = dvd::find($id);
        // Cari data dvd berdasarkan ID
        // $dvd = ....

        if (!$dvd) {
            return response()->json([
                'message' => 'dvd not found',
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }


        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please Check Your Request',
                "errors" => $validator->errors()
                // 'success' => false,
                // 'errors' => ....
            ], 422);
        }
          $dvd->update($validator->validated());
        // Update data dvd
        // $dvd->....
           return (new dvdResource($dvd))
                  -> additional(['message' => 'dvd updated Succsessfully'])
                  ->response()
                  ->setStatusCode(200);
        // return dvd yang diupdate sebagai resource
        // return ....
    }

    /**
     * ===========5================
     * Buat fungsi destroy untuk menghapus data dvd
     */
    public function destroy(string $id)
    {
        // Cari data dvd berdasarkan ID
        // $dvd = ....
          $dvd = dvd::find($id);

        if (!$dvd) {
            return response()->json([
                'message' => 'dvd not found'
                // 'success' => false,
                // 'message' => ....
            ], 404);
        }
          

        $dvd->delete();
        // Hapus data dvd
        // $dvd->....
         return response()->json(['message' => 'dvd deleted successfully']);
        // return message sukses
        // return ....
    }
}
