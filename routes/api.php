<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ApiDefaultController;
use App\Http\Controllers\Api\ApiController;

use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Routing\ActionRegistrar;
use LaravelJsonApi\Laravel\Routing\Relationships;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use App\Http\Controllers\Api\V2\OperatorController;
use App\Http\Controllers\Api\V2\ServerController;
use App\Http\Controllers\Api\V2\ContentTypeController;
use App\Http\Controllers\Api\V2\StandardController;
use App\Http\Controllers\Api\V2\WebResourceController;
use App\Http\Controllers\Api\V2\UserController;
use App\Http\Controllers\Api\V2\AdminUserController;
use App\Http\Controllers\Api\V2\TowerController;
use App\Http\Controllers\Api\V2\TestController;
use App\Http\Controllers\Api\V2\AuthController;
use App\Http\Controllers\Api\V2\UploadController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/websocket', function () {
    event(new App\Events\RealTimeMessage('Hello World'));
});

Route::group(['prefix' => 'v1',  'middleware' => ['log.route']], function (){
    Route::get('/show/{table}/{api_id?}', [ApiDefaultController::class, 'show'])->name('show-data-api');
    Route::post('/create/{table}', [ApiDefaultController::class, 'create'])->name('create-data-api');
    Route::put('/update/{table}/{api_id}', [ApiDefaultController::class, 'update'])->name('update-data-api');
    Route::delete('/delete/{table}/{api_id}', [ApiDefaultController::class, 'delete'])->name('delete-data-api');

    Route::post('/create-user', [ApiController::class, 'createUser'])->name('create-user-api');
    Route::get('/get-start-tower', [ApiController::class, 'getStartTower'])->name('get-start-tower-api');
    Route::get('/get-base-tower', [ApiController::class, 'getBaseTower'])->name('get-base-tower-api');
    Route::get('/get-location-towers', [ApiController::class, 'getLocationTowers'])->name('get-location-towers-api');
    Route::post('/create-test', [ApiController::class, 'createTest'])->name('create-test-api');
    Route::post('/upload-feedback-mail', [ApiController::class, 'uploadFeedbackMail'])->name('upload-feedback-mail-api');
    Route::post('/upload-image', [ApiController::class, 'uploadImage'])->name('upload-image-api');
    Route::get('/get-last-tests', [ApiController::class, 'getLastTests'])->name('get-last-tests-api');
    Route::get('/get-servers', [ApiController::class, 'getServers'])->name('get-servers-api');
    Route::get('/get-web-resources', [ApiController::class, 'getWebResources'])->name('get-web-resources-api');
});

Route::prefix('v2')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('upload-image', [UploadController::class, 'uploadImage']);
        Route::post('upload-feedback-mail', [UploadController::class, 'uploadFeedbackMail']);
    });
});

JsonApiRoute::server('v2')->prefix('v2')->resources(function (ResourceRegistrar $server) {
    $server->resource('operators', OperatorController::class);
    $server->resource('servers', ServerController::class);
    $server->resource('connection-types', ContentTypeController::class);
    $server->resource('standards', StandardController::class);
    $server->resource('web-resources', WebResourceController::class);
    $server->resource('users', UserController::class);
    $server->resource('admin-users', AdminUserController::class);
    $server->resource('towers', TowerController::class)
        ->relationships(function (Relationships $relations) {
            $relations->hasOne('operator')->readOnly();
            $relations->hasOne('standard')->readOnly();
        })->actions(function (ActionRegistrar $actions) {
            $actions->get('get-location-towers', 'getLocationTowers')->middleware('auth:sanctum');
            $actions->get('get-start-tower', 'getStartTower')->middleware('auth:sanctum');
            $actions->get('get-base-tower', 'getBaseTower')->middleware('auth:sanctum');
        });

    $server->resource('tests', TestController::class);
});
