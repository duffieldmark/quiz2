<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('quizzes/get-all', 'ApiController@getAllQuizzes');
Route::get('quizzes/get-quiz/{id}', 'ApiController@getQuiz');
Route::post('quizzes/add-quiz', 'ApiController@createQuiz');
Route::put('quizzes/update-quiz/{id}', 'ApiController@updateQuiz');
Route::delete('quizzes/delete-quiz/{id}','ApiController@deleteQuiz');

// Questions logic
Route::get('questions/get-all', 'ApiController@getAllQuestions');
Route::put('questions/{id}/update', 'ApiController@updateQuestion');
Route::delete('questions/{id}/delete', 'ApiController@deleteQuestion');
Route::post('questions/add-question', 'ApiController@addQuestion');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

// Need to create a way to clear an answer (only on d and e)
