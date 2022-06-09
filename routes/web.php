<?php
use App\Http\Controllers\Admins\AdminDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use App\Http\Controllers\Admins\RoleController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\News\NewsController;
use App\Http\Controllers\Virus\VirusController;
use App\Http\Controllers\File\FileController;
use App\Http\Controllers\Tickets\TicketController;
use App\Http\Controllers\HomepageController;
use App\Charts\DonutChart;
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



Route::get('/', function () {
    return Inertia::render('Homepage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware([])->get('/homepage', function () {
    return Inertia::render('Homepage');
})->name('homepage');

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum','verified'])->group(function
(){


    Route::get('dashboard',[AdminDashboardController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/markAsRead',[AdminDashboardController::class, 'markAsRead']);
    Route::get('dashboard/unreadNotifications',[AdminDashboardController::class, 'unreadNotifications']);
    Route::get('dashboard/updateNotification',[AdminDashboardController::class, 'updateNotification']);
    Route::get('dashboard/MaR',[AdminDashboardController::class, 'MaR']);

    Route::resource('admins',AdminController::class)->parameters(['admins'=>'user'])->only(['index','update']);

    Route::resource('users',UserController::class)->except(['create','show','edit']);

    Route::resource('permissions',PermissionController::class)->except(['create','show','edit']);

    Route::resource('roles',RoleController::class)->except(['create','show','edit']);

});

Route::prefix('news')->name('news.')->middleware(['auth:sanctum','verified'])->group(function
(){
    Route::get('news',[NewsController::class, 'index'])->name('news.index');
});

Route::prefix('virus')->name('virus.')->middleware(['auth:sanctum','verified'])->group(function
(){
    Route::get('virus',[VirusController::class, 'index'])->name('virus.virus');

});

Route::prefix('File')->name('File.')->middleware(['auth:sanctum','verified'])->group(function
(){
    Route::get('File',[FileController::class, 'index'])->name('File.File');
});

Route::prefix('tickets')->name('tickets.')->middleware(['auth:sanctum','verified'])->group(function
(){
    Route::get('ticket',[TicketController::class, 'index'])->name('index');
    Route::post('ticket',[TicketController::class, 'store'])->name('store');
    Route::patch('{ticket}',[TicketController::class, 'update'])->name('update');
    Route::delete('{ticket}',[TicketController::class, 'destroy'])->name('destroy');
});

Route::get('/chart',function(){

    $chart=(new ArielMejiaDev\LarapexCharts\LarapexChart())->donutChart()
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->addData([20, 24, 30])
            ->setLabels(['Player 7', 'Player 10', 'Player 9'])
            ->toVue();

    return inertia::render('Chart', compact('chart'));

});

Route::get('/send-alert',[AlertController::class,'sendAlert']);



