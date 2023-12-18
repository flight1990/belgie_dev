<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V2\GetBaseTowerRequest;
use App\Http\Requests\Api\V2\GetLocationTowersRequest;
use App\Http\Requests\Api\V2\GetStartTowerRequest;
use App\JsonApi\V2\Towers\TowerQuery;
use App\JsonApi\V2\Towers\TowerRequest;
use Modules\Towers\Models\Tower;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use LaravelJsonApi\Core\Responses\DataResponse;
use LaravelJsonApi\Laravel\Http\Controllers\Actions;

class TowerController extends Controller
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

    protected const KILOMETER = 0.00899808;

    /**
     * Возвращает вышки по айди или по радиусу
     *
     * @OA\Get(
     *     path="/api/v2/towers/get-base-tower",
     *     tags={"API V2 Towers"},
     *     operationId="getBaseTowerV2",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="x",
     *          description="Долгота",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="y",
     *          description="Широта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="msc",
     *          description="MSC",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="standard_id",
     *          description="Standard ID",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="cell_id",
     *          description="CELL ID",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
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
    public function getBaseTower(GetBaseTowerRequest $request): DataResponse
    {
        if ($request->filled('cell_id') && $request->get('cell_id') != 0 && $request->get('cell_id') <= 156568597) {
            $tower = $this->getTowerByCell($request);
        } else {
            $tower = $this->getTowerByParams($request);
        }

        return new DataResponse($tower);
    }

    protected function getTowerByCell(Request $request): Model|null
    {
        return Tower::query()
            ->where('cell_id', $request->get('cell_id'))
            ->firstOrFail();
    }

    protected function getTowerByParams(Request $request): Model|null
    {
        $towers = Tower::query()
            ->where('standard_id', $request->get('standard_id'))
            ->whereHas('operator', function ($query) use ($request) {
                $query->where('mnc', $request->get('mnc'));
            })
            ->get();

        $coordinates = $request->only(['x', 'y']);

        $arr = [];

        foreach ($towers as $single) {
            $arr[$single->id] = $single->getDistance($coordinates);
        }

        asort($arr);

        return Tower::query()
                ->whereId(array_keys($arr)[0] ?? [])
                ->firstOrFail();
    }


    /**
     * Возвращает локацию вышек находящихся в 1,5 радиуса от обслуживаемой вышки
     *
     * @OA\Get(
     *     path="/api/v2/towers/get-location-towers",
     *     tags={"API V2 Towers"},
     *     operationId="getLocationTowersV2",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="x",
     *          description="Долгота",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="y",
     *          description="Широта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="distance",
     *          description="Дистанция",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="number"
     *          )
     *      ),
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
    public function getLocationTowers(GetLocationTowersRequest $request): DataResponse
    {
        $distance = self::KILOMETER * $request->get('distance');

        $towers = Tower::whereBetween('x', [$request->get('x') - $distance, $request->get('x') + $distance])
            ->whereBetween('y', [$request->get('y') - $distance, $request->get('y') + $distance])
            ->paginate();

        return new DataResponse($towers);
    }

    /**
     * Возвращает ближайшие вышки от коодинат
     *
     * @OA\Get(
     *     path="/api/v2/towers/get-start-tower",
     *     tags={"API V2 Towers"},
     *     operationId="getStartTowerV2",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="x",
     *          description="Долгота",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="y",
     *          description="Широта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="mnc",
     *          description="MNC оператора",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="standard_id",
     *          description="ID Стандарта",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
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
    public function getStartTower(GetStartTowerRequest $request): DataResponse
    {
        $coordinates = $request->only(['x', 'y']);

        $towers = Tower::where('mnc', $request->get('mnc'))
            ->where('standard_id', $request->get('standard_id'))
            ->get();

        foreach($towers as $single){
            $arr[$single->id] = $single->getDistance($coordinates);
        }
        asort($arr);
        $array_key = [];
        foreach($arr as $key => $value){
            if(reset($arr) == $value){
                $array_key[] = $key;
            }
            else{
                break;
            }
        }

        $bsn = Tower::whereIn('id', $array_key)->first();
        $tower = Tower::where('bsn', $bsn->bsn)->where('mnc', $request->get('mnc'))->get();

        return new DataResponse($tower);
    }

    /**
     * Получение списка ресурсов
     *
     * @OA\Get(
     *     path="/api/v2/towers",
     *     tags={"API V2 Towers"},
     *     operationId="getAllTowers",
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
    public function reading(TowerQuery $query): void
    {

    }

    /**
     * Получение ресурса по ID
     *
     * @OA\Get(
     *     path="/api/v2/towers/{id}",
     *     tags={"API V2 Towers"},
     *     operationId="findTower",
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
    public function read(?Tower $tower, TowerQuery $query): void
    {

    }

    /**
     * Создание ресурса
     *
     * @OA\Post(
     *     path="/api/v2/towers",
     *     tags={"API V2 Towers"},
     *     operationId="storeTower",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                  "data" : {
     *                      "type": "towers",
     *                      "attributes" : {
     *                          "standard_id" : 2,
     *                          "operator_id" : 1,
     *                          "bsn" : 523,
     *                          "lac" : 116,
     *                          "cell_id" : 37650,
     *                          "mnc" : 1,
     *                          "x" : 27.56756,
     *                          "y" : 54.02928,
     *                          "band" : 1,
     *                          "sector" : 1
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
    public function creating(TowerRequest $request): void
    {

    }

    /**
     * Обновление ресурса
     *
     * @OA\Patch(
     *     path="/api/v2/towers/{id}",
     *     tags={"API V2 Towers"},
     *     operationId="updateTower",
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
     *                      "type": "towers",
     *                      "id" : "231362",
     *                      "attributes" : {
     *                          "standard_id" : 2,
     *                          "operator_id" : 1,
     *                          "bsn" : 523,
     *                          "lac" : 116,
     *                          "cell_id" : 37650,
     *                          "mnc" : 1,
     *                          "x" : 27.56756,
     *                          "y" : 54.02928,
     *                          "band" : 1,
     *                          "sector" : 1
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
    public function updating(Tower $tower, TowerRequest $request): void
    {

    }

    /**
     * Удаление ресурса
     *
     * @OA\Delete(
     *     path="/api/v2/towers/{id}",
     *     tags={"API V2 Towers"},
     *     operationId="deleteTower",
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
    public function deleting(?Tower $tower): void
    {

    }
}
