<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\JsonApi\V2\AdminUsers\AdminUserQuery;
use App\JsonApi\V2\AdminUsers\AdminUserRequest;
use App\JsonApi\V2\AdminUsers\AdminUserSchema;
use Modules\AdminUsers\Models\AdminUser;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class AdminUserController extends Controller
{
    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * Создание ресурса
     *
     * @OA\Post(
     *     path="/api/v2/admin-users",
     *     tags={"API V2 Admin Users"},
     *     operationId="storeAdminUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "admin-users",
     *                      "attributes" : {
     *                          "login" : "test",
     *                          "email" : "test@test.test",
     *                          "password" : "password",
     *                          "hash" : "3cc27c61794413360561c9093f0bcb29"
     *                      }
     *                   }
     *              }
     *           )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ресурс создан"
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
     *         response=422,
     *         description="Валидация не пройдена"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *     ),
     * )
     */
    public function store(AdminUserSchema $schema, AdminUserRequest $request, AdminUserQuery $query): DataResponse
    {
        $data = $request->validated();

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $model = $schema
            ->repository()
            ->create()
            ->withRequest($query)
            ->store($data);

        return new DataResponse($model);
    }

    /**
     * Обновление ресурса
     *
     * @OA\Patch(
     *     path="/api/v2/admin-users/{id}",
     *     tags={"API V2 Admin Users"},
     *     operationId="updateAdminUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID ресурса",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "admin-users",
     *                      "id" : "1",
     *                      "attributes" : {
     *                          "login" : "test",
     *                          "email" : "test@test.test",
     *                          "password" : "password"
     *                      }
     *                   }
     *              }
     *           )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ресурс получен"
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
     *         response=422,
     *         description="Валидация не пройдена"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *     ),
     * )
     */
    public function update(AdminUserSchema $schema, AdminUserRequest $request, AdminUserQuery $query, AdminUser $user): DataResponse
    {
        $data = $request->validated();

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $model = $schema
            ->repository()
            ->update($user)
            ->withRequest($query)
            ->store($data);

        return new DataResponse($model);
    }

    /**
     * Получение списка ресурсов
     *
     * @OA\Get(
     *     path="/api/v2/admin-users",
     *     tags={"API V2 Admin Users"},
     *     operationId="getAllAdminUsers",
     *     security={{"bearerAuth":{}}},
     *    @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Query параметры для филтрации и сортировки",
     *         required=false,
     *         @OA\Schema(
     *             type="object",
     *                  @OA\Property(
     *                      property="filter",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                      )
     *                  ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Ресурсы получены",
     *          @OA\MediaType(
     *           mediaType="application/vnd.api+json",
     *         )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Для доступа к ресурсу необходима авторизация",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="Нет разрешения на доступ к ресурсу",
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Ресурс не найден"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *      ),
     * )
     */
    public function reading(AdminUserQuery $query): void
    {

    }

    /**
     * Получение ресурса по ID
     *
     * @OA\Get(
     *     path="/api/v2/admin-users/{id}",
     *     tags={"API V2 Admin Users"},
     *     operationId="findAdminUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID ресурса",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Ресурс получен",
     *          @OA\MediaType(
     *           mediaType="application/vnd.api+json",
     *         )
     *      ),
     *     @OA\Response(
     *          response=401,
     *          description="Для доступа к ресурсу необходима авторизация",
     *      ),
     *     @OA\Response(
     *          response=403,
     *          description="Нет разрешения на доступ к ресурсу",
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Ресурс не найден"
     *      ),
     *     @OA\Response(
     *          response=500,
     *          description="Внутренняя ошибка сервера"
     *      ),
     * )
     */
    public function read(?AdminUser $user, AdminUserQuery $query): void
    {

    }

    /**
     * Удаление ресурса
     *
     * @OA\Delete(
     *     path="/api/v2/admin-users/{id}",
     *     tags={"API V2 Admin Users"},
     *     operationId="deleteAdminUser",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID ресурса",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Ресурс удален"
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
     *      ),
     * )
     */
    public function deleting(?AdminUser $users): void
    {

    }
}
