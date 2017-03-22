<?php

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
Route::get('/', function() {
    return view('members');
});

Route::get('/list-members', 'MemberController@getMemberList');
Route::get('/details-member/{id}', 'MemberController@detailsMember');
Route::post('/add-member', 'MemberController@addMember');
Route::post('/edit-member/{id}', 'MemberController@updateMember');
Route::post('/delete-member', 'MemberController@deleteMember');


//test
Route::post('upload/image' , 'MemberController@uploadImg');

//demo php unit test
Route::get('/test-phpunit','MemberController@getName');
