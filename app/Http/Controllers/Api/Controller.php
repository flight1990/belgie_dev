<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="БЕЛГИЕ API",
 *      description="API для работы с данных БЕЛГИЕ",
 *      @OA\Contact(
 *          email=""
 *      ),
 * )
 *
 * @OA\Server(
 *      url="http://belgie-v2",
 *      description="API Сервис"
 * )
 *
 * @OA\Tag(
 *     name="GET методы",
 *     description="API методы для получание данных"
 * )
 *
 * @OA\Tag(
 *     name="POST методы",
 *     description="API методы для сохранения данных"
 * )
 *
 * @OA\Tag(
 *     name="Общие методы",
 *     description="API методы"
 * )
 */
class Controller extends BaseController
{

}
