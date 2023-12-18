<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\Api\V2\LoginRequest;
use App\Http\Requests\Api\V2\RegisterRequest;
use Modules\AdminUsers\Models\AdminUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * Авторизация
     *
     * @OA\Post(
     *     path="/api/v2/login",
     *     tags={"API V2 Auth"},
     *     operationId="login",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                 "login" : "test",
     *                 "password" : "password"
     *              }
     *           )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно авторизирован"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cервер не может или не будет обрабатывать запрос"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Валидация не пройдена"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *     ),
     * )
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['login' => $request->get('login'), 'password' => $request->get('password')])) {

            $user = Auth::user();

            $response['token'] = $user->createToken('MyApp')->plainTextToken;
            $response['data'] = $user;

            return $this->sendResponse($response, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Регистрация
     *
     * @OA\Post(
     *     path="/api/v2/register",
     *     tags={"API V2 Auth"},
     *     operationId="register",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                 "name" : "test",
     *                 "login" : "test",
     *                 "password" : "password"
     *              }
     *           )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешно авторизирован"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cервер не может или не будет обрабатывать запрос"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Валидация не пройдена"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *     ),
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $payload = $request->validated();
        $payload['password'] = bcrypt($payload['password']);

        $user = AdminUser::create($payload);

        $response['token'] = $user->createToken('MyApp')->plainTextToken;
        $response['data'] = $user;

        return $this->sendResponse($response, 'User register successfully.');
    }

    /**
     * Выход из сессии
     *
     * @OA\Post(
     *     path="/api/v2/logout",
     *     tags={"API V2 Auth"},
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Выход из сессии"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cервер не может или не будет обрабатывать запрос"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Для доступа к ресурсу необходима авторизация",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="Нет разрешения на доступ к ресурсу",
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *     ),
     * )
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse([], 'User logout successfully.');
    }
}
