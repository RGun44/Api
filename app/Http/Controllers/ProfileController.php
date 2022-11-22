<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();

        if (count($profiles) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $profiles
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id)
    {
        $profile = Profile::find($id);
        if (!is_null($profile)) {
            return response([
                'message' => 'Retrieve User Success',
                'data' => $profile
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }


    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phonenumber' => 'required|numeric',
            'birthdate' => 'required'
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $profile = Profile::create($storeData);
        return response([
            'message' => 'Add profile Success',
            'data' => $profile
        ], 200);
    }


    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return response([
                'message' => 'profile Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username' => 'required',
            'password' => 'required',
            'email' => 'required',
            'phonenumber' => 'required|numeric',
            'birthdate' => 'required'
        ]);

        if ($validate->fails()) //Untuk mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400);

        $profile->profilename = $updateData['username'];
        $profile->password = $updateData['password'];
        $profile->email = $updateData['email'];
        $profile->phonenumber = $updateData['phonenumber'];
        $profile->birthdate = $updateData['birthdate'];

        if ($profile->save()) {
            return response([
                'message' => 'Update user Success',
                'data' => $profile
            ], 200);
        }

        return response([
            'message' => 'Update user Failed',
            'data' => null
        ], 400);
    }
}
