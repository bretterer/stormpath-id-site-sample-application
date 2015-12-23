<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
$spid = $_ENV['STORMPATH_ID'];
$spsecret = $_ENV['STORMPATH_SECRET'];
\Stormpath\Client::$apiKeyProperties = "apiKey.id=$spid\napiKey.secret=$spsecret";
$spapplication = \Stormpath\Resource\Application::get($_ENV['STORMPATH_APPLICATION']);



$app->get('/', function() use ($app) {
    $app->configure('app');
    return view('welcome');
});

$app->get('login', function() use ($spapplication) {
    $url = $spapplication->createIdSiteUrl(['callbackUri'=>'http://localhost:8000/idSiteResponse']);
    return redirect($url);
});

$app->get('register', function() use ($spapplication) {
    $url = $spapplication->createIdSiteUrl(['path'=>'/#/register','callbackUri'=>'http://localhost:8000/idSiteResponse']);
    return redirect($url);
});

$app->get('forgotPassword', function() use ($spapplication) {
    $url = $spapplication->createIdSiteUrl(['path'=>'/#/forgot','callbackUri'=>'http://localhost:8000/idSiteResponse']);
    return redirect($url);
});



$app->get('logout', function() use ($spapplication) {
    $url = $spapplication->createIdSiteUrl(['logout'=>true, 'callbackUri'=>'http://localhost:8000/idSiteResponse']);

    return redirect($url);
});

$app->get('idSiteResponse', function() use ($spapplication, $app) {
    try {
        $response = $spapplication->handleIdSiteCallback($_SERVER['REQUEST_URI']);
    } catch (Exception $e) {
        Session::flash('notice', $e->getMessage());
        return redirect('/');
    }
    switch($response->status) {
        case 'AUTHENTICATED' :
            Session::put('user', $response->account);
            Session::flash('notice', 'You have been logged in');
            return redirect('/');
            break;
        case 'LOGOUT' :
            Session::forget('user');
            Session::flash('notice', 'You have been logged out');
            return redirect('/');
            break;
        default :
            Session::flash('notice', 'We handled the ' . $response->status . ' response!');
            return redirect('/');


    }

});
