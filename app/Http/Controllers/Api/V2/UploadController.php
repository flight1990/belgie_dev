<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Requests\Api\V2\UploadFeedbackMailRequest;
use App\Http\Requests\Api\V2\UploadImageRequest;
use App\Mail\SendToMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UploadController extends BaseController
{
    /**
     * Загрузка изображения
     *
     * @OA\Post(
     *     path="/api/v2/upload-image",
     *     tags={"API V2 Upload"},
     *     operationId="uploadImageV2",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Изображение успешно загружено"
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
    public function uploadImage(UploadImageRequest $request): JsonResponse
    {
        return $this->sendResponse($request->validated(), 'Image has been uploaded successfuly.');
    }

    /**
     * Отправка псием
     *
     * @OA\Post(
     *     path="/api/v2/upload-feedback-mail",
     *     tags={"API V2 Upload"},
     *     operationId="uploadFeedbackMail",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Json data",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *              example={
     *                 "from" : "test@test.ru",
     *                 "subject" : "test email feedback",
     *                 "message" : "test email text message"
     *              }
     *           )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Сообщение успешно доставлено"
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
    public function uploadFeedbackMail(UploadFeedbackMailRequest $request): JsonResponse
    {
        $payload = $request->validated();

        Mail::to(config('mail.from.address'))
            ->send(new SendToMail($payload['from'], $payload['subject'], $payload['message']));

        return $this->sendResponse([], 'Message has been sent successfully.');
    }
}
