<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\V1\GetBaseTowerRequest;
use App\Http\Resources\ServersCollection;
use App\Http\Resources\TestsCollection;
use App\Http\Resources\TestsResource;
use App\Http\Resources\TowersCollection;
use App\Http\Resources\TowersResource;
use App\Http\Resources\WebResourcesResource;
use App\Mail\SendToMail;
use Modules\ConnectionTypes\Models\ConnectionType;
use Modules\Operators\Models\Operator;
use Modules\Servers\Models\Server;
use Modules\Standards\Models\Standard;
use Modules\Tests\Models\Test;
use Modules\Towers\Models\Tower;
use Modules\Users\Models\User;
use Modules\WebResources\Models\WebResource;

use App\Traits\HasNameOperator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Swift_Mailer;
use Swift_Message;
use Swift_SendmailTransport;
use Swift_SmtpTransport;


class ApiController extends Controller
{
    use HasNameOperator;

    public $param;
    protected const KILOMETER = 0.00899808;


    public function __construct(Request $request)
    {
        //Storage::disk('public')->prepend('logs/'.date("d-m-Y").'.txt', '['.date("d-m-Y H:i").']['.url()->full().'] '.implode('; ', $request->all()));
        $this->param = $request->all();
    }



    /**
     * @OA\Get(
     *      path="/api/v1/get-base-tower",
     *      operationId="getBaseTower",
     *      tags={"GET методы"},
     *      summary="Возвращает ближайшие вышки от коодинат",
     *      description="Возвращает ближайшие вышки от коодинат",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"x": 27.56667, "y": 53.9, "mnc": "1", "standard": "GSM", "cell_id": 1}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
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
     *          name="cell_id",
     *          description="cell_id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="stanard",
     *          description="Standard",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1074, "mnc": 1, "y": 53.90361, "x": 27.5601944444444},{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1075, "mnc": 1, "y": 53.90361, "x": 27.5601944444444},{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1076, "mnc": 1, "y": 53.90361, "x": 27.5601944444444}}, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getBaseTower(GetBaseTowerRequest $request): TowersResource
    {
        if ($request->filled('cell_id') && $request->get('cell_id') != 0 && $request->get('cell_id') <= 2147483647) {
            $tower = $this->getTowerByCellId($request);
        } else {
            $tower = $this->getTower($request);
        }

        if (is_null($tower)) {
            abort(404);
        }

        return new TowersResource($tower);
    }

    protected function getTowerByCellId(Request $request): Model|null
    {
        return Tower::query()
            ->where('cell_id', $request->get('cell_id'))
            ->first();
    }

    protected function getTower(Request $request)
    {
        try {
            $towers = Tower::query()

                ->when($request->filled('standard'), function ($query) use ($request) {

                    if (is_string($request->get('standard'))) {


                        $query->whereHas('standard', function ($query) use ($request) {
                            $query->where('name', $request->get('standard'));
                        });
                    } else {


                        $query->where('standard_id', $request->get('standard'));
                    }
                })
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
                ->first() ?? null;

        } catch (QueryException $e) {
            abort(400);
        }
    }


    /**
     * @OA\Post(
     *      path="/api/v1/create-user",
     *      operationId="createUser",
     *      tags={"POST методы"},
     *      summary="Создает пользователя",
     *      description="Создает пользователя",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"hash": "3c786cc9ffd0288dc717233509613e2d"}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="hash",
     *          description="Хеш пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Создан пользователь",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function createUser(Request $request)
    {
        if ($request->has('hash')) {
            $user = User::where('hash', $request->hash)->first();
            if (is_null($user)) {
                try {
                    $user = new User;
                    $user->hash = $request->hash;
                    $user->created_at = now();
                    $user->save();
                } catch (QueryException $e) {
                    return abort(400);
                }
            }
            return response()->json([], 201);
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-start-tower",
     *      operationId="getStartTower",
     *      tags={"GET методы"},
     *      summary="Возвращает ближайшие вышки от коодинат",
     *      description="Возвращает ближайшие вышки от коодинат",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"x": 27.56667, "y": 53.9, "mnc": "1"}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
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
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1074, "mnc": 1, "y": 53.90361, "x": 27.5601944444444},{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1075, "mnc": 1, "y": 53.90361, "x": 27.5601944444444},{"standard": "GSM", "operator": "MTS.BY", "bsn": 107, "lac": 107, "cell_id": 1076, "mnc": 1, "y": 53.90361, "x": 27.5601944444444}}, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getStartTower(Request $request)
    {
        /*dd($request->has('x'), $request->has('y'), $request->has('standard'), $request->has('mnc'));*/
        /*dd($request->has('y'));*/
        /*dd($request);*/
        /*dd($request->has('standard'));*/

        if ($request->has('x') && $request->has('y') && $request->has('mnc') && $request->has('standard')) {
            try {
                $coordinates = $request->only(['x', 'y']);
//                $operator_id = $this->getOperatorName($request->operator);
                /*$operator = Operators::where('mnc', $request->mnc)->pluck('id')->first();*/
                $standard = Standard::where('name', $request->standard)->pluck('id')->first();
                $towers = Tower::where('mnc', $request->mnc)->where('standard_id', $request->standard)
                    ->get();

                $arr = [];

                foreach ($towers as $single) {
                    $arr[$single->id] = $single->getDistance($coordinates);
                }
                asort($arr);
                $array_key = [];
                foreach ($arr as $key => $value) {
                    if (reset($arr) == $value) {
                        array_push($array_key, $key);
                    } else {
                        break;
                    }
                }
                $bsn = Tower::whereIn('id', $array_key)->first();
                $tower = Tower::where('bsn', $bsn->bsn ?? null)->where('mnc', $request->mnc)->get();
                return new TowersCollection($tower);
            } catch (QueryException $e) {
                return abort(400);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-location-towers",
     *      operationId="getLocationTowers",
     *      tags={"GET методы"},
     *      summary="Возвращает локацию вышек",
     *      description="Возвращает локацию вышек находящихся в 1,5 радиуса от обслуживаемой вышки",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"x": 27.56667, "y": 53.9, "distance": "1.60690009015365"}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
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
     *          name="distance",
     *          description="Дистанция",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={
    {
    "standard": "GSM",
    "operator": "A1 BY",
    "bsn": 5519,
    "lac": 103,
    "cell_id": 5271,
    "mnc": 1,
    "y": "53.8685833333333",
    "x": "27.3914722222222"
    },
    {
    "standard": "GSM",
    "operator": "A1 BY",
    "bsn": 5519,
    "lac": 103,
    "cell_id": 5272,
    "mnc": 1,
    "y": "53.8685833333333",
    "x": "27.3914722222222"
    },
    {
    "standard": "GSM",
    "operator": "A1 BY",
    "bsn": 5519,
    "lac": 103,
    "cell_id": 5273,
    "mnc": 1,
    "y": "53.8685833333333",
    "x": "27.3914722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3011,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3012,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3013,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3014,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3015,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3016,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    },
    {
    "standard": "GSM",
    "operator": "life:) BY",
    "bsn": 1005,
    "lac": 100,
    "cell_id": 10051,
    "mnc": 4,
    "y": "53.8726111110051",
    "x": "27.4016666666667"
    },
    {
    "standard": "GSM",
    "operator": "life:) BY",
    "bsn": 1005,
    "lac": 100,
    "cell_id": 10052,
    "mnc": 4,
    "y": "53.8726111110051",
    "x": "27.4016666666667"
    },
    {
    "standard": "GSM",
    "operator": "life:) BY",
    "bsn": 1005,
    "lac": 100,
    "cell_id": 10053,
    "mnc": 4,
    "y": "53.8726111110051",
    "x": "27.4016666666667"
    },
    {
    "standard": "GSM",
    "operator": "A1 BY",
    "bsn": 157,
    "lac": 103,
    "cell_id": 1571,
    "mnc": 1,
    "y": "53.8722222222222",
    "x": "27.4021388888889"
    },
    {
    "standard": "GSM",
    "operator": "A1 BY",
    "bsn": 157,
    "lac": 103,
    "cell_id": 1572,
    "mnc": 1,
    "y": "53.8722222222222",
    "x": "27.4021388888889"
    }
    }, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getLocationTowers(Request $request)
    {
        if ($request->has('x') && $request->has('y') && $request->has('distance')) {
            try {
                $distance = self::KILOMETER * $request->distance;
                $standard = Standard::where('name', $request->standard)->pluck('id')->first();
                $towers = Tower::whereBetween('x', [$request->x - $distance, $request->x + $distance])
                    ->whereBetween('y', [$request->y - $distance, $request->y + $distance])
                    ->get();
                return new TowersCollection($towers);
            } catch (QueryException $e) {
                return abort(400);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/create-test",
     *      operationId="createTest",
     *      tags={"POST методы"},
     *      summary="Создает тест",
     *      description="Создает тест",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"x": 27.56667, "y": 53.9, "hash": "3c786cc9ffd0288dc717233509613e2d", "mnc": "MTS.BY", "standard": "GSM", "connection_type": "3G", "server_ip": "212.98.179.84"}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
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
     *          name="hash",
     *          description="Хеш пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
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
     *      @OA\Parameter(
     *          name="standard",
     *          description="Стандарт",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="connection_type",
     *          description="Технология",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="server_ip",
     *          description="Тестовый сервер",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="created_at",
     *          description="Дата и время создание теста",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="model_phone",
     *          description="Модель мобильного телефона",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="version_os",
     *          description="Версия ОС",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="level_signal",
     *          description="Уровень принимаемого сигнла, дБм",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="max_speed_download",
     *          description="Максимальная скорость передачи данных (режим download), Мб/с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="medium_speed_download",
     *          description="Средняя скорость передачи данных (режим download), Мб/с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="max_speed_upload",
     *          description="Максимальная скорость передачи данных (режим upload), Мб/с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="min_speed_upload",
     *          description="Средняя скорость передачи данных (режим upload), Мб/с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="max_ping",
     *          description="Максимальное время задержки передачи IP-пакетов (ping), с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="medium_ping",
     *          description="Среднее время задержки передачи IP-пакетов (ping), с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="loss_ping",
     *          description="Количество потеряных IP-пакетов",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address_site_1",
     *          description="Адрес  вебстраницы №1",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address_site_2",
     *          description="Адрес  вебстраницы №2",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address_site_3",
     *          description="Адрес  вебстраницы №3",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="time_download_web_1",
     *          description="Время загрузки вебстраницы №1,с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="time_download_web_2",
     *          description="Время загрузки вебстраницы №2,с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="time_download_web_3",
     *          description="Время загрузки вебстраницы №3,с",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="load_web_1",
     *          description="Нагрузка вебстраницы №1, кБ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="load_web_2",
     *          description="Нагрузка вебстраницы №2, кБ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="load_web_3",
     *          description="Нагрузка вебстраницы №3, кБ",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="address_youtube",
     *          description="Адрес youtube - страницы (url)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="screen_resolution",
     *          description="Разрешение экрана №1-№5 (360р-8k)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="time_start",
     *          description="Время начала воспроизведения, c",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data_used",
     *          description="Использовано данных, Кб",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="complaint",
     *          description="Отправка результата на улучшение качества сети",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="is_room",
     *          description="Тест проведен в помещении?",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="boolean"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={
    "test": 1176,
    "x": "27.39132",
    "y": "53.86862",
    "created_at": "2022-05-24T07:02:23.000000Z",
    "model_phone": null,
    "version_os": null,
    "level_signal": null,
    "distance": 0.8069000901536539,
    "max_speed_download": null,
    "medium_speed_download": null,
    "max_speed_upload": null,
    "min_speed_upload": null,
    "max_ping": null,
    "medium_ping": null,
    "loss_ping": null,
    "address_site_1": null,
    "address_site_2": null,
    "address_site_3": null,
    "time_download_web_1": null,
    "time_download_web_2": null,
    "time_download_web_3": null,
    "load_web_1": null,
    "load_web_2": null,
    "load_web_3": null,
    "address_youtube": null,
    "screen_resolution": null,
    "time_start": null,
    "data_used": null,
    "complaint": false,
    "is_room": false,
    "operator": "MTS.BY",
    "provider": "MTS",
    "standard": "GSM",
    "connection_type": "-",
    "server": "212.98.179.84",
    "user": "-",
    "tower": {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3011,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    }}, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function createTest(Request $request)
    {
        if ($request->has('x') && $request->has('y') && $request->has('hash') && $request->has('mnc') && $request->has('standard') && $request->has('connection_type') && $request->has('server_ip')) {
            $operator = Operator::where('mnc', $request->mnc)->first();
            $standard = Standard::where('name', $request->standard)->first();
            $connection_type = ConnectionType::where('name', $request->connection_type)->first();
            $server = Server::where('name', $request->server_ip)->first();
            $user = User::where('hash', $request->hash)->first();

            try{
                $towers = Tower::where('operator_id', $operator->id)
                    ->where('standard_id', $standard->id)
                    ->get();

                $coordinates = $request->only(['x', 'y']);

                $arr = [];

                foreach($towers as $single){
                    $arr[$single->id] = $single->getDistance($coordinates);
                }

                asort($arr);

                $tower = !empty($arr) ? Tower::whereId(array_keys($arr)[0])->first() : null;

            }
            catch (QueryException $e) {
                return abort(400);
            }
//            $tower = $this->getTower($request);
            if (!is_null($user) && !is_null($tower)) {
                try {
                    $test = new Test;

                    $test->x = $request->x;
                    $test->y = $request->y;
                    $test->band = $request->get('band', null);
                    $test->sector = $request->get('sector', null);
                    $test->created_at = $request->has('created_at') ? $request->created_at : now();
                    $test->model_phone = $request->has('model_phone') ? $request->model_phone : null;
                    $test->version_os = $request->has('version_os') ? $request->version_os : null;
                    $test->level_signal = $request->has('level_signal') ? $request->level_signal : null;
                    $test->distance = $arr[array_keys($arr)[0]];
                    $test->max_speed_download = $request->has('max_speed_download') ? $request->max_speed_download : null;
                    $test->medium_speed_download = $request->has('medium_speed_download') ? $request->medium_speed_download : null;
                    $test->max_speed_upload = $request->has('max_speed_upload') ? $request->max_speed_upload : null;
                    $test->min_speed_upload = $request->has('min_speed_upload') ? $request->min_speed_upload : null;
                    $test->max_ping = $request->has('max_ping') ? $request->max_ping : null;
                    $test->medium_ping = $request->has('medium_ping') ? $request->medium_ping : null;
                    $test->loss_ping = $request->has('loss_ping') ? $request->loss_ping : null;
                    $test->address_site_1 = $request->has('address_site_1') ? $request->address_site_1 : null;
                    $test->address_site_2 = $request->has('address_site_2') ? $request->address_site_2 : null;
                    $test->address_site_3 = $request->has('address_site_3') ? $request->address_site_3 : null;
                    $test->time_download_web_1 = $request->has('time_download_web_1') ? $request->time_download_web_1 : null;
                    $test->time_download_web_2 = $request->has('time_download_web_2') ? $request->time_download_web_2 : null;
                    $test->time_download_web_3 = $request->has('time_download_web_3') ? $request->time_download_web_3 : null;
                    $test->load_web_1 = $request->has('load_web_1') ? $request->load_web_1 : null;
                    $test->load_web_2 = $request->has('load_web_2') ? $request->load_web_2 : null;
                    $test->load_web_3 = $request->has('load_web_3') ? $request->load_web_3 : null;
                    $test->address_youtube = $request->has('address_youtube') ? $request->address_youtube : null;
                    $test->screen_resolution = $request->has('screen_resolution') ? $request->screen_resolution : null;
                    $test->time_start = $request->has('time_start') ? $request->time_start : null;
                    $test->data_used = $request->has('data_used') ? $request->data_used : null;
                    $test->complaint = $request->has('complaint') ? $request->complaint : false;
                    $test->is_room = $request->has('is_room') ? $request->is_room : false;

                    $test->operator_id = $operator->id ?? null;
                    $test->standard_id = $standard->id ?? null;
                    $test->connection_type_id = $connection_type->id ?? null;
                    $test->server_id = $server->id ?? null;
                    $test->user_id = $user->id;
                    $test->tower_id = $tower->id;

                    $test->save();

                } catch (QueryException $e) {
                    return abort(400);
                }
                return new TestsResource($test);
            }

            return abort(400);
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-last-tests",
     *      operationId="getLastTests",
     *      tags={"GET методы"},
     *      summary="Возвращает последнии тесты",
     *      description="Возвращает определенное количество последних тестов Пользователя",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"hash": "3c786cc9ffd0288dc717233509613e2d", "count": 10}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="hash",
     *          description="Хеш пользователя",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="count",
     *          description="Количество",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          description="Тип теста (full, speed, web, video)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={
    {
    "test": 1175,
    "x": "27.39132",
    "y": "53.86862",
    "created_at": "2022-05-23T21:00:00.000000Z",
    "model_phone": null,
    "version_os": null,
    "level_signal": null,
    "distance": "0.80690009015365",
    "max_speed_download": null,
    "medium_speed_download": null,
    "max_speed_upload": null,
    "min_speed_upload": null,
    "max_ping": null,
    "medium_ping": null,
    "loss_ping": null,
    "address_site_1": null,
    "address_site_2": null,
    "address_site_3": null,
    "time_download_web_1": null,
    "time_download_web_2": null,
    "time_download_web_3": null,
    "load_web_1": null,
    "load_web_2": null,
    "load_web_3": null,
    "address_youtube": null,
    "screen_resolution": null,
    "time_start": null,
    "data_used": null,
    "complaint": false,
    "is_room": false,
    "operator": "MTS.BY",
    "provider": "MTS",
    "standard": "GSM",
    "connection_type": "-",
    "server": "212.98.179.84",
    "user": "-",
    "tower": {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3011,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    }
    },
    {
    "test": 1176,
    "x": "27.39132",
    "y": "53.86862",
    "created_at": "2022-05-23T21:00:00.000000Z",
    "model_phone": null,
    "version_os": null,
    "level_signal": null,
    "distance": "0.80690009015365",
    "max_speed_download": null,
    "medium_speed_download": null,
    "max_speed_upload": null,
    "min_speed_upload": null,
    "max_ping": null,
    "medium_ping": null,
    "loss_ping": null,
    "address_site_1": null,
    "address_site_2": null,
    "address_site_3": null,
    "time_download_web_1": null,
    "time_download_web_2": null,
    "time_download_web_3": null,
    "load_web_1": null,
    "load_web_2": null,
    "load_web_3": null,
    "address_youtube": null,
    "screen_resolution": null,
    "time_start": null,
    "data_used": null,
    "complaint": false,
    "is_room": false,
    "operator": "MTS.BY",
    "provider": "MTS",
    "standard": "GSM",
    "connection_type": "-",
    "server": "212.98.179.84",
    "user": "-",
    "tower": {
    "standard": "GSM",
    "operator": "MTS.BY",
    "bsn": 301,
    "lac": 204,
    "cell_id": 3011,
    "mnc": 2,
    "y": "53.8727222222222",
    "x": "27.4014722222222"
    }
    }
    }, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getLastTests(Request $request)
    {
        if ($request->has('hash')) {
            $user = User::where('hash', $request->hash)->first();
            if (!is_null($user)) {
                $count = $request->has('count') ? intval($request->count) : 10;
                try {
                    $tests = Test::where('user_id', $user->id)
                        ->where(function ($query) use ($request) {
                            if (isset($request->type) && $request->type == 'full') {
                                $query->whereNotNull('max_speed_download');
                                $query->whereNotNull('address_site_1');
                                $query->whereNotNull('address_youtube');
                            } else if (isset($request->type) && $request->type == 'speed') {
                                $query->whereNotNull('max_speed_download');
                                $query->whereNull('address_site_1');
                                $query->whereNull('address_youtube');
                            } else if (isset($request->type) && $request->type == 'web') {
                                $query->whereNull('max_speed_download');
                                $query->whereNotNull('address_site_1');
                                $query->whereNull('address_youtube');
                            } else if (isset($request->type) && $request->type == 'video') {
                                $query->whereNull('max_speed_download');
                                $query->whereNull('address_site_1');
                                $query->whereNotNull('address_youtube');
                            }
                        })
                        ->orderBy('created_at', 'desc')
                        ->take($count)
                        ->get();
                } catch (QueryException $e) {
                    return abort(400);
                }
                return new TestsCollection($tests);
            } else {
                return abort(400);
            }
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-servers",
     *      operationId="getServers",
     *      tags={"GET методы"},
     *      summary="Возвращает список тестовых серверов",
     *      description="Возвращает список тестовых серверов",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={{"name": "212.98.179.84"}}, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getServers(Request $request)
    {
        try {
            $servers = Server::where('active', true)->get();
        } catch (QueryException $e) {
            return abort(400);
        }
        if (!is_null($servers)) {
            return new ServersCollection($servers);
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/get-web-resources",
     *      operationId="getWebResources",
     *      tags={"GET методы"},
     *      summary="Возвращает тестируемые веб-ресурсы",
     *      description="Возвращает тестируемые веб-ресурсы",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={"address_site_1": "https://www.google.com", "address_site_2": "https://yandex.by", "address_site_3": "https://www.youtube.com", "address_video": "EJr3uAQwGek", }, summary="Результат")
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function getWebResources(Request $request)
    {
        try {
            $web_resources = WebResource::where('active', true)->first();
        } catch (QueryException $e) {
            return abort(400);
        }
        if (!is_null($web_resources)) {
            return new WebResourcesResource($web_resources);
        } else {
            return abort(403);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/upload-image",
     *      operationId="uploadImage",
     *      tags={"POST методы"},
     *      summary="Загружает файл на сервер",
     *      description="Загружает файл на сервер для теста скорости",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="image",
     *          description="Картинка",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Неправильный, некорректный запрос",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Не найден сервис"
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Непредвиденная ошибка сервера"
     *      )
     * )
     */
    public function uploadImage(Request $request)
    {
        if ($request->file('image')) {
            return response()->json([], 200);
        } else {
            return response()->json([], 400);
        }
    }

    public function uploadFeedbackMail(Request $request)
    {
        if ($request->has('from') && $request->has('subject') && $request->has('hash') && $request->has('message')) {

            $from = $request->from;
            $subject = $request->subject;
            $message = $request->message;
            $hash = $request->hash;

            try {
                Mail::to('hvalya@belgie.by')->send(new SendToMail($from, $subject, $message));
            } catch (QueryException $e) {
                return abort(400);
            }
            return response()->json(['Message has been sent successfully'], 201);
        } else {
            return abort(403);
        }
    }


}
