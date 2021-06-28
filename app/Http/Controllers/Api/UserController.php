<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Device;
use App\Models\User;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends ApiController
{
    protected $user;

    protected $userTransformer;

    public function __construct(UserTransformer $userTransformer) {
        $this->userTransformer = $userTransformer;
    }

    public function logout(Request $req)
    {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);

        return $this->apiSuccess("Logout success!");
    }

    public function login(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'username' => 'required',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }
        $user = User::where('username', $req->username)->first();

        if (empty($user)) {
            return $this->apiErrorWithCode("User does not exist", 404);
        }

        if (!$token = JWTAuth::attempt($validator->validated())) {
            return $this->apiErrorWithCode("Wrong password", 422);
        }

        $tokenGenerateJwt = $user->generateJwt('id', $user['id']);
        $user->toArray();
        $data = [
            'id' => $user['id'],
            'token' => $tokenGenerateJwt,
            'phone_number' => $user['phone_number'],
            'created_at' => (string)$user['created_at'],
            'updated_at' => (string)$user['updated_at'],
        ];
        unset($user['id'], $user['phone_number'], $user['created_at'], $user['updated_at']);

        return $this->apiSuccess($data);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required|min:5',
            'email' => 'email|unique:users',
            'family_name' => 'required',
            'last_name' => 'required',
            'card_id' => 'required|unique:users',
            'phone_number' => 'required|unique:users',
            'birthday' => 'required',
            'sex' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiErrorWithCode($validator->errors(), 404);
        }

        $user = User::create($validator->validated());

        return $this->apiSuccess($this->userTransformer->transform($user));
    }


    public function getProfile(Request $request)
    {
        return $this->apiSuccess($this->userTransformer->transform(auth()->user()));
    }
}
