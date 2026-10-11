<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Resources\Admin\AdminAuthResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class adminController extends Controller
{
    public function login(AdminLoginRequest $request)
    {

        $admin = Admin::where('phone', $request->phone)->first();

        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The Phone Number is incorrect.'],
            ]);
        }

        return $this->makeToken($admin);
    }


    public function makeToken($admin)
    {
        $token = $admin->createToken('admin__Token')->plainTextToken;

        // return authresource::make($admin);

        return (new AdminAuthResource($admin))
                ->additional(['meta' => [
                    'token' => $token,
                    'token_type' => "bear_Token",
                ]]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return send_ms('admin logout', true, 200);
    }
    public function user(Request $request)
    {
        return AdminAuthResource::make($request->user());
    }
}
