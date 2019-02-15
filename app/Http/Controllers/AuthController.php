<?php

namespace App\Http\Controllers;

use Validator;
use Exception;
use App\User;
use App\Persona;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthController extends Controller
{
    function register(Request $data)
    {
      try{
        DB::beginTransaction();
        $result = $data->json()->all();
        $user = User::create([
            'name'=>$result['name'],
            'email'=>$result['email'],
            'password'=>$result['password'],
            'api_token'=>str_random(64),
        ]);
        DB::commit();
        return response()->json($user,200);
      } catch (Exception $e) {
        return response()->json($e,400);
      }
  
    }function registro(Request $data)
    {
      try{
        DB::beginTransaction();
        $result = $data->json()->all();
        $persona = Persona::create([
            'nombre'=>$result['nombre'],
            'mail'=>$result['mail'],
            'contra'=>$result['contra'],
            'token'=>str_random(64),
        ]);
        DB::commit();
        return response()->json($persona,200);
      } catch (Exception $e) {
        return response()->json($e,400);
      }
  
    }
  function login(Request $data)
  {
      $result = $data->json()->all();
      $email = $result['email'];
      $password = $result['password'];
      $user = User::where('email', $email)->first();
      if (!$user) {
        return response()->json([
          'error' => 'Bad Credentials'
        ], 400);
      }
      if ($password === $user->password) {
        $token = $this->jwt($user);
        $response = User::where('id',$user->id)->update([
          'api_token'=>$token,
        ]);
        return response()->json([
            'token' => $token,
            'name' => $user->name,
            'id' => $user->id
        ], 200);
      }
      return response()->json([
        'error' => 'Bad Credentials'
      ], 400);
  }
  protected function jwt(User $user) {
    $payload = [
        'subject' => $user->id,
        'creation_time' => time(),
        'expiration_time' => time() + 60*60
    ];
    return JWT::encode($payload, env('JWT_SECRET'));
  }
}
