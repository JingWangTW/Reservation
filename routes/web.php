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
use App\Models\Reservation as Reservation;
// all users page part
$router->group(['middleware' => 'warn'], function () use ($router) {
    
    $router->get ('/', [
        'as' => 'welcome', 
        'uses' => 'Page\UserPageController@index'] 
    );

    $router->get ('/home', [
        'middleware' => 'home_redirect',
        'as' => 'home', 
        'uses' => 'Page\UserPageController@home'] 
    );
    
    $router->get('test_home', function(){
        
        $classList =  Reservation::get2WeeksReservationClass();
        
        return view('page.user.test_home', ['classList' => $classList]);
    });
    
    $router->get ('/forget', [
        'as' => 'forget_password', 
        'uses' => 'Page\UserPageController@forgetPassword'] 
    );
});

// all student pages parts
$router->group(['middleware' => ['auth', 'student'], 'prefix' => '/student'], function () use ($router) {

    $router->get ('/', [
        'as' => 'student_home', 
        'uses' => 'Page\StudentPageController@home'] 
    );
    
    $router->get ('/change_password', [
        'as' => 'student_change_password', 
        'uses' => 'Page\StudentPageController@changePassword'] 
    );
    
});

// all assistant pages parts
$router->group(['middleware' => ['auth', 'assistant'], 'prefix' => '/assistant'], function () use ($router) {

    $router->get ('/', [
        'as' => 'assistant_home', 
        'uses' => 'Page\AssistantPageController@home'] 
    );
    
    $router->get ('/change_password', [
        'as' => 'assistant_change_password', 
        'uses' => 'Page\AssistantPageController@changePassword'] 
    );
    
    // add middle ware to check authorization
    $router->group(['middleware' => ['assistant_authorization']], function () use ($router) {

        $router->get ('/class_overview/{class_index}', [
            'as' => 'assistant_class_overview', 
            'uses' => 'Page\AssistantPageController@classOverview'] 
        );
    });
    
});

// all teacher pages parts
$router->group(['middleware' => ['auth', 'teacher'], 'prefix' => '/teacher'], function () use ($router) {


    $router->get ('/', [
        'as' => 'teacher_home', 
        'uses' => 'Page\TeacherPageController@home'] 
    );
    
    $router->get ('/create_class', [
        'as' => 'create_class', 
        'uses' => 'Page\TeacherPageController@createClass'] 
    );
    
    $router->get ('/add_students', [
        'as' => 'add_students', 
        'uses' => 'Page\TeacherPageController@addStudents'] 
    );
    
    $router->get ('/new_reservation', [
        'as' => 'add_reservation', 
        'uses' => 'Page\TeacherPageController@newReservation'] 
    );
    
    $router->get ('/new_assistant', [
        'as' => 'new_assistant', 
        'uses' => 'Page\TeacherPageController@newAssistant'] 
    );
    
    $router->get ('/schedule', [
        'as' => 'schedule', 
        'uses' => 'Page\TeacherPageController@schedule'] 
    );
    
    $router->get ('/change_password', [
        'as' => 'teacher_change_password', 
        'uses' => 'Page\TeacherPageController@changePassword'] 
    );
    
    $router->get ('/class_overview/{class_index}', [
        'as' => 'teacher_class_overview', 
        'uses' => 'Page\TeacherPageController@classOverview'] 
    );
});

// all api parts
$router->group(['prefix' => 'api'], function () use ($router) {
    
    $router->post('agree', 'API\UserController@signAgreeWarn');
    $router->get ('logout', 'API\AccountController@logout');
    $router->post('forget_pwd', 'API\AccountController@forgetPwd');
    $router->post('reset_pwd', 'API\AccountController@resetPwd');
    
    $router->group(['middleware' => 'warn'], function ()  use ($router) {

        $router->post('login', 'API\AccountController@login');
    
    });
    
    $router->group(['middleware' => 'auth'], function ()  use ($router) {

        $router->post('change_pwd', 'API\AccountController@changePwd');
    
    });

    $router->group(['middleware' => ['auth', 'student']], function () use ($router) {

        $router->post('making_reservation', 'API\StudentController@makingReservation');
    
    });
    
    $router->group(['middleware' => ['auth', 'teacher']], function () use ($router) {

        $router->post('create_class', 'API\TeacherController@createClass');
        $router->post('add_students', 'API\TeacherController@addStudents');
        $router->post('add_assistant', 'API\TeacherController@addAssistant');
        $router->post('add_reservation_class', 'API\TeacherController@addReservationClass');
        $router->post('edit_reservation_class', 'API\TeacherController@editReservationClass');
        $router->post('delete_reservation_class', 'API\TeacherController@deleteReservationClass');
    
    });
});

// all files part
$router->group(['prefix' => 'file'], function () use ($router) {
    
    $router->get('system/{fileName}', 'FileManager\SystemFile@service');
    
});

$router->get ('/verifyMail/{token}', [
    'as' => 'verify_mail', 
    'uses' => 'Page\UserPageController@verifyMail'] 
);


$router->get('hash_password', function(){
    return password_hash("admin", PASSWORD_BCRYPT);
});


/*
$router->get('/', function () use ($router) {
    
return view('welcome_page');
    //return $router->app->version();
});
*/
