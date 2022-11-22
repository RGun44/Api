<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::all();

        if (count($pakets) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pakets
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'daerah_asal' => 'required',
            'daerah_tujuan' => 'required',
            'berat_paket' => 'required|numeric',
            'kecepatan' => 'required'
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $paket = Paket::create($storeData);
        return response([
            'message' => 'Add paket Success',
            'data' => $paket
        ], 200);
    }

    public function show($id)
    {

        $paket = Paket::find($id);
        if (!is_null($paket)) {
            return response([
                'message' => 'Retrieve Paket Success',
                'data' => $paket
            ], 200);
        }

        return response([
            'message' => 'Paket Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::find($id);

        if (is_null($paket)) {
            return response([
                'message' => 'paket Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'daerah_asal' => 'required',
            'daerah_tujuan' => 'required',
            'berat_paket' => 'required|numeric',
            'kecepatan' => 'required'
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $paket->daerah_asal = $updateData['daerah_asal'];
        $paket->daerah_tujuan = $updateData['daerah_tujuan'];
        $paket->berat_paket = $updateData['berat_paket'];
        $paket->kecepatan = $updateData['kecepatan'];

        if ($paket->save()) {
            return response([
                'message' => 'Update paket Success',
                'data' => $paket
            ], 200);
        }

        return response([
            'message' => 'Update paket Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id)
    {
        $paket = Paket::find($id);

        if (is_null($paket)) {
            return response([
                'message' => 'Paket Not Found',
                'data' => null
            ], 404);
        }

        if ($paket->delete()) {
            return response([
                'message' => 'Delete Paket Success',
                'data' => $paket
            ], 200);
        }

        return response([
            'message' => 'Delete Paket Failed',
            'data' => null
        ], 400);
    }
}
