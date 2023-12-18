<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDefaultController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/show/{table}/{api_id?}",
     *      operationId="showRecords",
     *      tags={"Общие методы"},
     *      summary="Список записей",
     *      description="Возращает список записей",
     *      @OA\Parameter(
     *          name="table",
     *          description="Название таблицы",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="api_id",
     *          description="Идентификационный номер записи",
     *          required=false,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result_not_id", value={{"param": "param1"}, {"param": "param2"}}, summary="Результат без передачей api_id"),
     *              @OA\Examples(example="result_with_id", value={{"param": "param1"}}, summary="Результат с передачей api_id"),
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
     *     )
     */
    public function show(Request $request, $table, $api_id = null)
    {
        if(isset($table)){
            $data = DB::table($table);
            if(isset($api_id)){
                $data->where('id', $api_id);
            }
            try{
                $data = $data->get();
            }
            catch (QueryException $e) {
                return abort(400);
            }
            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        else{
            return abort(403);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/create/{table}",
     *      operationId="createRecord",
     *      tags={"Общие методы"},
     *      summary="Создание записис",
     *      description="Создание записис",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"param": "param"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="table",
     *          description="Название таблицы",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="param",
     *          description="Параметры",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(@OA\Examples(example="result", value={"param": "param"}, summary="Возращаемый объект"),)
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
    public function create(Request $request, $table)
    {
        if(isset($table)){
            try{
                DB::table($table)->insert($this->param);
            }
            catch (QueryException $e) {
                return abort(400);
            }
            return true;
        }
        else{
            return abort(403);
        }
    }

    /**
     * @OA\Put(
     *      path="/api/v1/update/{table}/{api_id}",
     *      operationId="updateRecord",
     *      tags={"Общие методы"},
     *      summary="Изменение записи",
     *      description="Изменение записи выбранной таблицы",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"param": "param"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *          name="table",
     *          description="Название таблицы",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="api_id",
     *          description="Идентификационный номер записи",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="param",
     *          description="Параметры",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Пакет получен",
     *          @OA\JsonContent(@OA\Examples(example="result", value={"param": "param"}, summary="Возращаемый объект"),)
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Структура пакета неверна",
     *      ),
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
    public function update(Request $request, $table, $api_id)
    {
        if(isset($table) && isset($api_id)){
            try{
                DB::table($table)->where('id', $api_id)->update($this->param);
            }
            catch (QueryException $e) {
                return abort(400);
            }
            return true;
        }
        else{
            return abort(403);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/delete/{table}/{api_id?}",
     *      operationId="deleteRecord",
     *      tags={"Общие методы"},
     *      summary="Удаление записи",
     *      description="Удаление записи",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 example={"table": "table", "api_id": 2}
     *             )
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="table",
     *          description="Название таблицы",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="api_id",
     *          description="Идентификационный номер записи",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
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
    public function delete(Request $request, $table, $api_id)
    {
        if(isset($table) && isset($api_id)){
            try{
                DB::table($table)->where('id', $api_id)->delete();
            }
            catch (QueryException $e) {
                return abort(400);
            }
            return true;
        }
        else{
            return abort(403);
        }
    }
}
