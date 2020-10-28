<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return view('index');
});

/* Pray Time API from Diyanet */
$router->get('/pray-time/countries', ['as' => 'countries', 'uses' => 'PrayTimeController@getCountries']);
$router->get('/pray-time/locations/{country_id:[0-9]+}', ['as' => 'locations', 'uses' => 'PrayTimeController@getLocations']);
$router->get('/pray-time/times/{location_id:[0-9]+}', ['as' => 'times', 'uses' => 'PrayTimeController@getTimes']);

/* Horoscope API from Hurriyet */
$router->get('/horoscope/signs', ['as' => 'horoscopes', 'uses' => 'HoroscopeController@getHoroscopes']);
$router->get('/horoscope/interpretation/{horoscope_name}', ['as' => 'horoscopes.interpretation', 'uses' => 'HoroscopeController@interpretation']);

/* Earthquake API from Kandilli */
$router->get('/earthquake/list/{limit:[0-9]+}', ['as' => 'earthquake.list', 'uses' => 'EarthquakeController@getEarthquakes']);

/* Currency API from TCMB and X-Rates(converter) */
$router->get('/currency/tcmb', ['as' => 'currency.tcmb', 'uses' => 'CurrencyController@tcmbCurrencies']);
$router->get('/currency/list', ['as' => 'currency', 'uses' => 'CurrencyController@getCurrencies']);
$router->get('/currency/latest/{from}', ['as' => 'currency', 'uses' => 'CurrencyController@getCurrency']);
