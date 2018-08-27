<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// all users page part
$router->group(['middleware' => 'warn'], function () use ($router) {
    
    $router->get ('/', [
        'as' => 'welcome', 
        'uses' => 'Page\UserPageController@index'] 
    );

    $router->get ('/home', [
        'as' => 'home', 
        'uses' => 'Page\UserPageController@home'] 
    );
});

// all student pages parts
$router->group(['middleware' => ['auth', 'student']], function () use ($router) {

    $router->get ('/student', [
        'as' => 'student_home', 
        'uses' => 'Page\StudentPageController@home'] 
    );
    
});

// all assistant pages parts
$router->group(['middleware' => ['auth', 'assistant']], function () use ($router) {

    $router->get ('/assistant', [
        'as' => 'assistant_home', 
        'uses' => 'Page\AssistantPageController@home'] 
    );
    
});

// all teacher pages parts
$router->group(['middleware' => ['auth', 'teacher']], function () use ($router) {

    $router->get ('/teacher', [
        'as' => 'teacher_home', 
        'uses' => 'Page\TeacherPageController@home'] 
    );
    
    $router->get ('/teacher/create_class', [
        'as' => 'create_class', 
        'uses' => 'Page\TeacherPageController@createClass'] 
    );
    
    
    $router->get ('/teacher/add_students', [
        'as' => 'add_students', 
        'uses' => 'Page\TeacherPageController@addStudents'] 
    );
    
    $router->get ('/teacher/new_reservation', [
        'as' => 'add_reservation', 
        'uses' => 'Page\TeacherPageController@newReservation'] 
    );
    
    $router->get ('/teacher/new_assistant', [
        'as' => 'new_assistant', 
        'uses' => 'Page\TeacherPageController@newAssistant'] 
    );
});

// all api parts
$router->group(['prefix' => 'api'], function () use ($router) {
    
    $router->post('agree', 'API\UserController@signAgreeWarn');
    
    $router->post('login', 'API\AccountController@login');
    
    $router->get ('logout', 'API\AccountController@logout');
    
    
    $router->group(['middleware' => ['auth', 'teacher']], function () use ($router) {

        $router->post('create_class', 'API\TeacherController@createClass');
        $router->post('add_students', 'API\TeacherController@addStudents');
        $router->post('add_assistant', 'API\TeacherController@addAssistant');
        $router->post('add_reservation', 'API\TeacherController@addReservation');
    
    });
});

// all files part
$router->group(['prefix' => 'file'], function () use ($router) {
    
    $router->get('system/{fileName}', 'FileManager\SystemFile@service');
    
});


$router->get('hash_password', function(){
    return password_hash("admin", PASSWORD_BCRYPT);
});


/*
$router->get('/', function () use ($router) {
    
return view('welcome_page');
    //return $router->app->version();
});
*/
