<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:4",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {

            return send_error('Validation Error', $validator->errors(), 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $data = [
                'name' => $user->name,
                'email' => $user->email,
            ];
            return send_response('User registration successfull', $data);
        } catch (Exception $e) {

            return send_error($e->getMessage(), $e->getCode());
        }
    }
}