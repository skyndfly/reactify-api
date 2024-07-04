<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="Register new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema (
     *                 type="object",
     *                 required={"email", "name", "pasword", "password_confirmation"},
     *                  @OA\Property(
     *                      property="email",
     *                      type="string",
     *                      description="User email",
     *                      example="test@test.ru"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="User name",
     *                      example="Sergey Golubev"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      description="User password",
     *                      example="example"
     *                  ),
     *                  @OA\Property(
     *                      property="password_confirmation",
     *                      type="string",
     *                      description="User password confirmation",
     *                      example="example"
     *                  )
     *             )
     *         )
     *     ) ,
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property (
     *                 property="message",
     *                 description="Message",
     *                 example="Succes.",
     *                 type="string"
     *             ),
     *             @OA\Property (
     *                 property="token",
     *                 description="Auth token",
     *                 type="string",
     *                 example="6|vdusnxcjrhNsqh9DZ6RhmT9GwP90ilkkmv43D3bHce04ca0a"
     *             )
     *         )
     *
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validate exception",
     *         @OA\JsonContent(
     *             @OA\Property (
     *                 property="message",
     *                 type="object",
     *                 description="Errors object",
     *                 @OA\Property (
     *                  property="email",
     *                  type="array",
     *                  @OA\Items(
     *                      type="string",
     *                      example="The email has already been taken"
     *                  )
     *                 ),
     *                 @OA\Property (
     *                   property="password",
     *                   type="array",
     *                   @OA\Items(
     *                       type="string",
     *                       example="The password field confirmation does not match.",
     *                   )
     *                  )
     *             )
     *
     *         )
     *     )
     * )
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create($data);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['message' => 'Success.', 'token' => $token], 200);
        } catch (ValidationException $exception) {
            return response()->json(['message' => $exception->errors()], 422);
        }
    }
    public function login(Request $request)
    {

        return response()->json(['message' => 'Успешно зарегистрирован!'], 200);
    }
}
