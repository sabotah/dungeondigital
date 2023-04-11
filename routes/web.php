<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbilityController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CampaignAreaController;
use App\Http\Controllers\CampaignCreatureController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CreatureController;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\EnvironmentRowController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomEntityController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacypolicy', function () {
    return view('privacypolicy');
});

Route::get('/dndlicense', function () {
    return view('dndlicense');
});

Route::get('/texttovoice',[HomeController::class,'textToVoice']);

Route::get('characters/{characterid}/tablemap','CharacterController@tableMap');

Auth::routes();

Route::get('/feedbackform', function () {
    return view('feedback');
});

Route::post('/feedbackform',[HomeController::class,'postFeedback']);

Route::get('/home', [HomeController::class,'index'])->name('home');

Route::resource('characters', CharacterController::class);
Route::resource('campaigns', CampaignController::class);

Route::get('/campaigns/{campaignid}/setaudioroom/{roomid}',[CampaignController::class,'setAudioRoom']);

Route::resource('areas', AreaController::class);
Route::resource('rooms', RoomController::class);

Route::post('/rooms/{roomid}/listen',[RoomController::class,'listenToRoom']);

Route::resource('doors', DoorController::class);
Route::resource('entities', EntityController::class);
Route::resource('roomentities', RoomEntityController::class);

Route::resource('creatures', CreatureController::class);
Route::resource('abilities', AbilityController::class);
Route::resource('actions', ActionController::class);
Route::resource('campaigncreatures', CampaignCreatureController::class);
Route::resource('environments', EnvironmentController::class);
Route::resource('extensions', ExtensionController::class);

Route::post('/areas/{areaid}/campaigns/{campaignid}',[CampaignAreaController::class,'toggleCampaignArea']);

Route::post('/campaigns/{campaignid}/characters/{characterid}',[CharacterController::class,'toggleCampaignCharacter']);

Route::get('/campaigncharacters',[CharacterController::class,'viewCampaignCharacters']);

Route::post('/getcharactersfromemail',[CharacterController::class,'getCharactersFromEmail']);

Route::get('/campaigns/{campaignid}/areas/{areaid}',[CampaignController::class,'showCampaignArea']);

Route::get('/checkupdates/{characterid}',[CharacterController::class,'checkUpdates']);

Route::get('/checkcharacterrequests/{areaid}/{campaignid}',[CharacterController::class,'checkCharacterRequests']);

// Route::post('/creatures/import','CreatureController@import');
Route::get('/searchcreatures',[CreatureController::class,'searchCreatures']);

Route::get('/campaigncreatures/{campaigncreatureid}/unassign',[CampaignCreatureController::class,'unassign']);
Route::get('/characters/{characterid}/unassign',[CharacterController::class,'unassign']);

// Route::get('users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
// Route::patch('users/{user}/update',  ['as' => 'users.update', 'uses' => 'UserController@update']);
Route::get('users/{user}', [UserController::class,'edit']);
Route::patch('users/{user}/update',  [UserController::class,'update']);

Route::get('/discordcallback',[HomeController::class,'discordCallback']);

Route::post('/creatediscordchannel',[HomeController::class,'createDiscordChannel']);

Route::get('/publiccampaigns/{characterid}',[CampaignController::class,'publicIndex']);

Route::post('/joinpubliccampaign',[CampaignController::class,'joinPublicCampaign']);
