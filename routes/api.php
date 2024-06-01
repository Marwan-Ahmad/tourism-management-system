<?php

use App\Http\Controllers\Admin\activatycontroller;
use App\Http\Controllers\Admin\airplanecontroller;
use App\Http\Controllers\Admin\authcontroller;
use App\Http\Controllers\Admin\BalanceController;
use App\Http\Controllers\Admin\countrycontroller;
use App\Http\Controllers\Admin\expertcontroller;
use App\Http\Controllers\Admin\flighttripcontroller;
use App\Http\Controllers\Admin\hotelcontroller;
use App\Http\Controllers\Admin\profilecontroller as AdminProfilecontroller;
use App\Http\Controllers\Admin\touristplacecontroller;
use App\Http\Controllers\client\activatycontroller as ClientActivatycontroller;
use App\Http\Controllers\client\airplanecontroller as ClientAirplanecontroller;
use App\Http\Controllers\client\authcontroller as ClientAuthcontroller;
use App\Http\Controllers\client\BalanceController as ClientBalanceController;
use App\Http\Controllers\client\bookingscontroller;
use App\Http\Controllers\client\countrycontroller as ClientCountrycontroller;
use App\Http\Controllers\client\expertcontroller as ClientExpertcontroller;
use App\Http\Controllers\client\flighttripcontroller as ClientFlighttripcontroller;
use App\Http\Controllers\client\hotelcontroller as ClientHotelcontroller;
use App\Http\Controllers\client\profilecontroller;
use App\Http\Controllers\client\touristplacecontroller as ClientTouristplacecontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Torism;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/





##########################Genral####################
//THIS IS REGISTER AND LOGIN FOR TOW CLIENTS AND ADMINS SO I WILL PORTED THEM
//I WILL NOT LET THEM LIKE THIS
//1- LOGIN FO ADMIN
//1- LOGIN FOR CLIENT
//2-REGISTER FOR CLIENT


#############################ADMIN########################################
Route::post('loginAdmin',[authcontroller::class,'login']);
// admin country
Route::group(["middleware"=>["auth:sanctum"]],function(){
Route::get('ReturnCountreyForAdmin',[countrycontroller::class,'ReturnCountrey']);
Route::post('InputCountry',[countrycontroller::class,'InputCountry']);
Route::post('DropCountry',[countrycontroller::class,'DropCountry']);
Route::post('UpdateInformationContrey',[countrycontroller::class,'UpdateInformationContrey']);

// admin airplane
Route::get('getcompany',[airplanecontroller::class,'getcompany']);
Route::post('InputAirPlaneCompany',[airplanecontroller::class,'InputAirPlaneCompany']);
Route::post('updateAirplaneCompany',[airplanecontroller::class,'updateAirplaneCompany']);
Route::post('DropAirplaneCompany',[airplanecontroller::class,'DropAirplaneCompany']);


// admin flight trip
Route::get('gettrip',[flighttripcontroller::class,'gettrip']);
Route::post('InputFlightTrip',[flighttripcontroller::class,'InputFlightTrip']);
Route::post('DropFlightTrip',[flighttripcontroller::class,'DropFlightTrip']);
Route::post('UpdateFlightTrip',[flighttripcontroller::class,'UpdateFlightTrip']);

// admin hotel
Route::post('inputHotelInformation',[hotelcontroller::class,'inputHotelInformation']);
Route::post('DropHotel',[hotelcontroller::class,'DropHotel']);
Route::post('updateHotel',[hotelcontroller::class,'updateHotel']);

// admin tourist place
Route::post('inputInoformationTouirstPlace',[touristplacecontroller::class,'inputInoformationTouirstPlace']);
Route::post('UpdateInoformationTouirstPlace',[touristplacecontroller::class,'UpdateInoformationTouirstPlace']);
Route::post('DropTouirstPlace',[touristplacecontroller::class,'DropTouirstPlace']);

// admin experts
Route::post('inputInformationOfExpert',[expertcontroller::class,'inputInformationOfExpert']);
Route::post('UpdateInfomationOfExpert',[expertcontroller::class,'UpdateInfomationOfExpert']);
Route::post('DropExpert',[expertcontroller::class,'DropExpert']);

// admin activate
Route::post('InputInformationOfActivity',[activatycontroller::class,'InputInformationOfActivity']);
Route::post('DropActivtiy',[activatycontroller::class,'DropActivtiy']);
Route::post('UpdateInformationActivity',[activatycontroller::class,'UpdateInformationActivity']);


Route::get('adminProfile',[AdminProfilecontroller::class,'adminProfile']);
Route::post('updateadminprofile',[AdminProfilecontroller::class,'updateadminprofile']);


//account api balance
Route::get('getClientsAccount',[BalanceController::class,'getClientsAccount']);
//Route::post('CreateAccountForClient',[BalanceController::class,'CreateAccountForClient']);
Route::post('DeleteAccountClient',[BalanceController::class,'DeleteAccountClient']);
Route::post('UpdateClientAccount',[BalanceController::class,'UpdateClientAccount']);

Route::get('logoutAdmin',[authcontroller::class,'logout']);

});


###############################CLIENT###########################################
Route::post('register',[ClientAuthcontroller::class,'register']);

Route::post('loginClient',[ClientAuthcontroller::class,'login']);
// client information country
Route::group(["middleware"=>["auth:sanctum"]],function(){
Route::post('SearchAboutContrey',[ClientCountrycontroller::class,'SearchAboutContrey']);
Route::get('ReturnCountrey',[ClientCountrycontroller::class,'ReturnCountrey']);

// client information ait plane company
Route::post('SearchAboutAirPlaneCompany',[ClientAirplanecontroller::class,'SearchAboutAirPlaneCompany']);
//Route::get('GetDescrrptionrAirPlanes',[ClientAirplanecontroller::class,'GetDescrrptionrAirPlanes']);
Route::get('GetAirPlanesCompany',[ClientAirplanecontroller::class,'GetAirPlanesCompany']);
//Route::post('ServiceOfCompnayAirplane',[ClientAirplanecontroller::class,'ServiceOfCompnayAirplane']);


// client information trip and company for trip
Route::get('gettripclient',[Clientflighttripcontroller::class,'gettrip']);
Route::get('GetReserveTrip',[Clientflighttripcontroller::class,'GetReserveTrip']);
Route::get('getunpayedtrip',[Clientflighttripcontroller::class,'getunpayedtrip']);


Route::post('ResveFlightTrip',[ClientFlighttripcontroller::class,'ResveFlightTrip']);
Route::post('DeleteReserveTrip',[ClientFlighttripcontroller::class,'DeleteReserveTrip']);
Route::post('UpdateInfoReserve',[ClientFlighttripcontroller::class,'UpdateInfoReserve']);



Route::post('getCompanyORCountryWithTrips',[ClientFlighttripcontroller::class,'getCompanyORCountryWithTrips']);



// client inforamtion hotell
Route::post('SearchAboutHotel',[ClientHotelcontroller::class,'SearchAboutHotel']);
Route::post('ReturnCountreyWithHotel',[ClientHotelcontroller::class,'ReturnCountreyWithHotel']);
Route::post('ReserveRoom',[ClientHotelcontroller::class,'ReserveRoom']);


// client tourist place
Route::post('getcountreyWithTourirstPlace',[ClientTouristplacecontroller::class,'getcountreyWithTourirstPlace']);
Route::post('SearchAboutTouristPlace',[ClientTouristplacecontroller::class,'SearchAboutTouristPlace']);

// client information about expeert
Route::post('getCountryWithExpert',[ClientExpertcontroller::class,'getCountryWithExpert']);
Route::post('ReservExpert',[ClientExpertcontroller::class,'ReservExpert']);

// client infrmation about activty
Route::post('ReserveAvtivity',[ClientActivatycontroller::class,'ReserveAvtivity']);
Route::get('GetActivities',[ClientActivatycontroller::class,'GetActivities']);


// Profile
/* this route for the [
    1-booking expert
    2-booking trips
    3-booking hotels
    4-booking active
    ]
    */
Route::post('CheckBookingExpert',[bookingscontroller::class,'CheckBookingExpert']);
Route::post('CheckBookingTrips',[bookingscontroller::class,'CheckBookingTrips']);
Route::post('CheckBookingHotels',[bookingscontroller::class,'CheckBookingHotels']);
Route::post('CheckBookingActivity',[bookingscontroller::class,'CheckBookingActivity']);


//client and admin[profile and logout]in middlewar becouse they need token todothis

    Route::get('ProfileClient',[profilecontroller::class,'Profile']);
    Route::post('updateclientprofile',[profilecontroller::class,'updateclientprofile']);
    Route::get('logoutClient',[ClientAuthcontroller::class,'logout']);

    //myaccount
    Route::get('getmyaccount',[ClientBalanceController::class,'getmyaccount']);
    Route::post('PayedToTrip',[ClientBalanceController::class,'PayedToTrip']);





}
);
Route::get('ImageTest',[Torism::class,'ImageTest']);







// the comment we will return to them when we finsh

// Route::get('GetCounterWithAirPlanes',[Torism::class,'GetCounterWithAirPlanes']);
// Route::get('getCompanyWithTrips',[Torism::class,'getCompanyWithTrips']);
// Route::post('ReturnCountreyWithAirplanes',[Torism::class,'ReturnCountreyWithAirplanes']);
// Route::get('logout',[Torism::class,'logout']);