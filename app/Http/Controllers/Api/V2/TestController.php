<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\JsonApi\V2\Tests\TestQuery;
use App\JsonApi\V2\Tests\TestRequest;
use Modules\Tests\Models\Test;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class TestController extends Controller
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
     *     path="/api/v2/tests",
     *     tags={"API V2 Tests"},
     *     operationId="getAllTests",
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
    public function reading(TestQuery $query): void
    {

    }

    /**
     * Получение ресурса по ID
     *
     * @OA\Get(
     *     path="/api/v2/tests/{id}",
     *     tags={"API V2 Tests"},
     *     operationId="findTest",
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
    public function read(?Test $test, TestQuery $query): void
    {

    }

    /**
     * Создание ресурса
     *
     * @OA\Post(
     *     path="/api/v2/tests",
     *     tags={"API V2 Tests"},
     *     operationId="storeTest",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "standards",
     *                      "attributes" : {
     *                          "x" : 27.56756,
     *                          "y" : 54.02928,
     *                          "band" : 2600,
     *                          "sector" : 5,
     *                          "model_phone" : "SM-G991Btest",
     *                          "version_os" : "30",
     *                          "level_signal" : "-77",
     *                          "distance" : 0.086700411277338,
     *                          "max_speed_download" : 22.19,
     *                          "medium_speed_download" : 0.9,
     *                          "max_speed_upload" : 3.81,
     *                          "min_speed_upload" : 3.73,
     *                          "max_ping" : 740,
     *                          "medium_ping" : 400.8,
     *                          "address_site_1" : "https://www.google.com",
     *                          "screen_resolution" : "automatic",
     *                          "data_used" : "480",
     *                          "complaint" : true,
     *                          "operator_id" : 1,
     *                          "standard_id" : 1,
     *                          "connection_type_id" : 1,
     *                          "server_id" : 1,
     *                          "tower_id" : 1,
     *                          "load_web_1" : "15",
     *                          "load_web_2" : "30",
     *                          "load_web_3" : "45",
     *                          "is_room" : false,
     *                          "time_start" : 0.807,
     *                          "time_download_web_1" : 666,
     *                          "time_download_web_2" : 777,
     *                          "time_download_web_3" : 888,
     *                          "loss_ping" : 400,
     *                          "user_id" : 100
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
    public function creating(TestRequest $request): void
    {

    }

    /**
     * Обновление ресурса
     *
     * @OA\Patch(
     *     path="/api/v2/tests/{id}",
     *     tags={"API V2 Tests"},
     *     operationId="updateTest",
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
     *                      "type": "tests",
     *                      "id" : "13520",
     *                      "attributes" : {
     *                          "x" : 27.56756,
     *                          "y" : 54.02928,
     *                          "band" : 2600,
     *                          "sector" : 5,
     *                          "model_phone" : "SM-G991Btest",
     *                          "version_os" : "30",
     *                          "level_signal" : "-77",
     *                          "distance" : 0.086700411277338,
     *                          "max_speed_download" : 22.19,
     *                          "medium_speed_download" : 0.9,
     *                          "max_speed_upload" : 3.81,
     *                          "min_speed_upload" : 3.73,
     *                          "max_ping" : 740,
     *                          "medium_ping" : 400.8,
     *                          "address_site_1" : "https://www.google.com",
     *                          "screen_resolution" : "automatic",
     *                          "data_used" : "480",
     *                          "complaint" : true,
     *                          "operator_id" : 1,
     *                          "standard_id" : 1,
     *                          "connection_type_id" : 1,
     *                          "server_id" : 1,
     *                          "tower_id" : 1,
     *                          "load_web_1" : "15",
     *                          "load_web_2" : "30",
     *                          "load_web_3" : "45",
     *                          "is_room" : false,
     *                          "time_start" : 0.807,
     *                          "time_download_web_1" : 666,
     *                          "time_download_web_2" : 777,
     *                          "time_download_web_3" : 888,
     *                          "loss_ping" : 400,
     *                          "user_id" : 100
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
    public function updating(Test $test, TestRequest $request): void
    {

    }

    /**
     * Удаление ресурса
     *
     * @OA\Delete(
     *     path="/api/v2/tests/{id}",
     *     tags={"API V2 Tests"},
     *     operationId="deleteTest",
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
    public function deleting(?Test $test): void
    {

    }

}
