<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/events', 'EventController@getEventsForHome');


Route::get('/user/login', 'UserController@showLoginForm')->name('login');

Route::post('/user/auth', 'UserController@authenticate')->name('auth');

Route::get('/user/auth', 'UserController@getAuthenticatedUser')->name('authenticated');

Route::get('/user/search/{text}/{onlyContacts?}/{user?}', 'UserController@searchUsers')->name('user-search');

Route::get('/user/contacts/{id}', 'UserController@getUserContacts')->name('user-contacts');

Route::get('/user/contacts/recents/{id}', 'UserController@getRecentContacts')->name('user-recent-contacts');


Route::get('/conversation/data/{id}', 'ConversationMessageController@getConversationDataById')->name('conversation-by-id');

Route::get('/conversation/history/{user}/{skip?}/{take?}', 'ConversationMessageController@getConversationHistory')->name('messages-history');

Route::post('/conversation/messages/user/send', 'ConversationMessageController@sendMessageToUser');

Route::post('/conversation/messages/group/send', 'ConversationMessageController@sendMessageToGroup');

Route::post('/conversation/messages/read', 'ConversationMessageController@updateMessageAsRead');

Route::get('/conversation/messages/{conversation}/{skip?}/{take?}', 'ConversationMessageController@getMessagesOfConversation')->name('conversation-messages');

Route::post('/conversation/user/create', 'ConversationMessageController@createUserConversation')->name('conversation-user-create');

Route::post('/conversation/group/create', 'ConversationMessageController@createGroupConversation')->name('conversation-group-create');


Route::post('/group/save', 'GroupController@addOrUpdateGroup')->name('group-save');

Route::post('/group/partipants/add', 'GroupController@addParticipantToGroup')->name('group-add-participants');


Route::get('/call/{id}', 'CallController@getCallInfosById')->name('call-by-id');

Route::post('/call/create', 'CallController@createCall')->name('call-create');


Route::post('/call/invite/create', 'CallController@createCallInvite')->name('call-invite-create');

Route::get('/call/invite/{id}', 'CallController@addMemberToCallThroughInvite')->name('call-member-add');


Route::post('/call/member/allow', 'CallController@acceptMember');

Route::post('/call/member/deny', 'CallController@denyMember');

Route::post('/call/member/disconnect', 'CallController@disconnectMemberOfCall');

Route::post('/call/member/audio/mute-unmute', 'CallController@muteUnmuteAudio');

Route::post('/call/member/video/show-hide', 'CallController@showHideVideo');
