<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login', 'register']]);
	}

	public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');

		if ($token = auth('api')->attempt($credentials)) {
			if (!Auth::user()->suspend) {
				return $this->respondWithToken($token);
			} else {
				return response()->json(['error' => 'Unauthorized'], 401);
			}
		}
		return response()->json(['error' => 'Unauthorized'], 401);
	}

	public function register(Request $request)
	{
		$request->validate([
			'name' => 'required',
			'email' => 'required|unique:"users"|email',
			'password' => 'required|min:6|max:20|confirmed',
		]);

		$user = new User();
		$user->name = $request->name;
		$user->slug = Str::slug($request->name) . Str::random(3);
		$user->email = $request->email;
		$user->password = Hash::make($request->password);
		$user->save();
	}

	public function user()
	{
		return response()->json(auth('api')->user());
	}

	public function logout()
	{
		auth('api')->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	public function refresh()
	{
		return $this->respondWithToken(auth('api')->refresh());
	}

	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('api')->factory()->getTTL() * 60
		]);
	}

	public function guard()
	{
		return Auth::guard();
	}
}
