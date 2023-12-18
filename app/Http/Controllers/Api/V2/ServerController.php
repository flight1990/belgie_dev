<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\JsonApi\V2\Servers\ServerQuery;
use App\JsonApi\V2\Servers\ServerRequest;
use Modules\Servers\Models\Server;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class ServerController extends Controller
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
     *     path="/api/v2/servers",
     *     tags={"API V2 Servers"},
     *     operationId="getAllServers",
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
    public function reading(ServerQuery $query): void
    {

    }

    /**
     * Получение ресурса по ID
     *
     * @OA\Get(
     *     path="/api/v2/servers/{id}",
     *     tags={"API V2 Servers"},
     *     operationId="findServer",
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
    public function read(?Server $server, ServerQuery $query): void
    {

    }

    /**
     * Создание ресурса
     *
     * @OA\Post(
     *     path="/api/v2/servers",
     *     tags={"API V2 Servers"},
     *     operationId="storeServer",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "servers",
     *                      "attributes" : {
     *                          "name" : "test",
     *                          "active" : true
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
    public function creating(ServerRequest $request): void
    {

    }

    /**
     * Обновление ресурса
     *
     * @OA\Patch(
     *     path="/api/v2/servers/{id}",
     *     tags={"API V2 Servers"},
     *     operationId="updateServer",
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
     *                      "type": "servers",
     *                      "id" : "16",
     *                      "attributes" : {
     *                          "name" : "test",
     *                          "active" : true
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
    public function updating(Server $server, ServerRequest $request): void
    {

    }

    /**
     * Удаление ресурса
     *
     * @OA\Delete(
     *     path="/api/v2/servers/{id}",
     *     tags={"API V2 Servers"},
     *     operationId="deleteServer",
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
    public function deleting(?Server $server): void
    {

    }

}
