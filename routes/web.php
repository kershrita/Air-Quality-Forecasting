<?php

use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/storage'; // Added a slash (/)

    if (!file_exists($linkFolder)) {
        symlink($targetFolder, $linkFolder);
        return 'Symlink created successfully.';
    } else {
        return 'Symlink already exists.';
    }
});

Route::get('/opt', function () {
    Artisan::call('optimize');
    return 1;
});


Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');



Route::middleware('localization')->group(function () {


    ///////////////////////////  dashboard admin   ///////////////////////////////////////////////////////////

            Route::get('/',[HomeController::class,'dashboard']);
            Route::get('/dashboard',[HomeController::class,'dashboard'])->name("dashboard");
            Route::get('/dashboard2',[HomeController::class,'dashboard2'])->name("dashboard2");
            Route::get('/arunachal_pradesh',[HomeController::class,'arunachal_pradesh'])->name("arunachal_pradesh");


    });

