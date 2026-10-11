<?php

namespace App\Http\Controllers\api\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\user\loginRequest;
use App\Http\Resources\user\authresource;
use App\Http\Requests\user\registerRequest;
use App\Http\Requests\user\OtpVerifyRequest;
use App\Http\Resources\User\WishlistResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;


class authController extends Controller
{
    public function login(LoginRequest $request)
    {


        $user = User::verifiedUser()->where('phone', $request->phone)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $this->makeToken($user);
    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            $data = twilio_env();
            $res = $data->verifications->create("+88" . $user->phone, "sms");
            return send_ms('Otp Send Success', $res->status, 200);
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }


    public function OTPResend(Request $request)
    {
        try {
            $user = User::where('phone', $request->phone)->first();
            $data = twilio_env();
            $res = $data->verifications->create("+88" . $user->phone, "sms");
            return send_ms('Otp Send Success', $res->status, 200);
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }

    public function verifyOtp(OtpVerifyRequest $request)
    {
        try {
            $data = twilio_env();
            $res =   $data->verificationChecks->create(
                [
                    "to" => "+88" . $request->phone,
                    "code" => $request->otp_code
                ]
            );

            if ($res->status === 'approved') {
                $user = User::where('phone', $request->phone)->first();
                $user->update(['isVerified' => 1]);
                return $this->makeToken($user);
            } else {
                throw ValidationException::withMessages([
                    'otp_code' => ['The provided Otp Code are incorrect.'],
                ]);
            }
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }

    }


    public function makeToken($user)
    {
        $wishlist = $user->userWishlistProducts()->get();
        $token = $user->createToken('__Token')->plainTextToken;

        // return authresource::make($user);

        return (new authresource($user))
                ->additional(['meta' => [
                    'token' => $token,
                    'token_type' => "bear_Token",
                    'wishlist' => $wishlist,
                ]]);
    }

    public function logout(Request $request)
    {

        try {
            $request->user()->tokens()->delete();
            return send_ms('User Logout', true, 200);
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
    public function user(Request $request)
    {
        return authresource::make($request->user());
    }

    public function address(Request $request)
    {
        $id = Auth::guard('user-api')->id();


        $data = User::where('id', $id)->select('division_id', 'district_id', 'address')->with([
            'division' => function ($query) {
                $query->select('name', 'id');
        },'district' => function ($query) {
                $query->select('name', 'id');
        }])->first();

        return WishlistResource::make($data);
    }

}
