<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Auth;
class AuthController extends Controller
{
  /**
   * Create a new AuthController instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth:api', ['except' => ['login','Register']]);
  }

  /**
   * Get a JWT via given credentials.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
      $this->handleLoginValidation($request);
      $credentials = request(['email', 'password']);

      if (! $token = auth()->attempt($credentials)) {
          return response()->json(['error' => 'Unauthorized'], 401);
      }
      return $this->respondWithToken($token);
  }
  protected function handleLoginValidation($request)
  {
    $this->validate($request,[
      'email'=>'required|max:50',
      'password'=>'required|max:100',
    ]);
  }
  /**
   * Get the authenticated User.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function me()
  {
      return response()->json(auth()->user());
  }

  /**
   * Log the user out (Invalidate the token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout()
  {
      auth()->logout();

      return response()->json(['message' => 'Successfully logged out']);
  }

  /**
   * Refresh a token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh()
  {
      return $this->respondWithToken(auth()->refresh());
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken($token)
  {
      return response()->json([
          'access_token' => $token,
          'token_type' => 'bearer',
          'expires_in' => auth()->factory()->getTTL() * 60,
          'name'=> Auth::user()->fname.' '.Auth::user()->lname,
      ]);
  }

  public function Register(Request $request)
  {
    $this->handleRegisterValidation($request);

    $userDB = new User;
    $userDB->fname = $request->fname;
    $userDB->lname = $request->lname;
    $userDB->email = $request->email;
    $userDB->gender = $request->gender;
    $userDB->password = bcrypt($request->password);
    $userDB->birthday = date($request->birthday.' 00:00:00');
    $userDB->lastSeen = Carbon::now();
    $userDB->save();

    return $this->login($request);
  }

  protected function handleRegisterValidation($request)
  {
    $this->validate($request,[
      'fname'=>'required|max:20|min:2',
      'lname'=>'required|max:20|min:2',
      'email'=>'required|max:50|min:5|confirmed|unique:users',
      'birthday'=>'required|max:50',
      'gender'=>'required|max:1',
      'password'=>'required|max:100',
    ]);
  }
}
