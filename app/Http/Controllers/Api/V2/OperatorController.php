<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\JsonApi\V2\Operators\OperatorQuery;
use App\JsonApi\V2\Operators\OperatorRequest;
use Modules\Operators\Models\Operator;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class OperatorController extends Controller
{
    use Actions\FetchMany;
    use Actions\FetchOne;
    use Actions\Store;
    use Actions\Update;
    use Actions\Destroy;
    use Actions\FetchRelated;
    use Actions\FetchRelationship;
    use Actions\UpdateRelationship;
    use Actions\AttachRelationship;
    use Actions\DetachRelationship;

    /**
     * Получение списка ресурсов
     *
     * @OA\Get(
     *     path="/api/v2/operators",
     *     tags={"API V2 Operators"},
     *     operationId="getAllOperators",
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
    public function reading(OperatorQuery $query): void
    {

    }

    /**
     * Получение ресурса по ID
     *
     * @OA\Get(
     *     path="/api/v2/operators/{id}",
     *     tags={"API V2 Operators"},
     *     operationId="findOperator",
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
    public function read(?Operator $operator, OperatorQuery $query): void
    {

    }

    /**
     * Создание ресурса
     *
     * @OA\Post(
     *     path="/api/v2/operators",
     *     tags={"API V2 Operators"},
     *     operationId="storeOperator",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "operators",
     *                      "attributes" : {
     *                          "name" : "test",
     *                          "provider" : "test",
     *                          "mnc" : 1
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
    public function creating(OperatorRequest $request): void
    {

    }

    /**
     * Обновление ресурса
     *
     * @OA\Patch(
     *     path="/api/v2/operators/{id}",
     *     tags={"API V2 Operators"},
     *     operationId="updateOperator",
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
     *                      "type": "operators",
     *                      "id" : "1",
     *                      "attributes" : {
     *                          "name" : "test",
     *                          "provider" : "test",
     *                          "mnc" : 1
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
    public function updating(Operator $operator, OperatorRequest $request): void
    {

    }

    /**
     * Удаление ресурса
     *
     * @OA\Delete(
     *     path="/api/v2/operators/{id}",
     *     tags={"API V2 Operators"},
     *     operationId="deleteOperator",
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
    public function deleting(?Operator $operator): void
    {

    }

}
