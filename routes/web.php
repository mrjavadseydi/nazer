<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ObserveController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PhysicalDocument;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\Report13Controller as Report13ControllerAlias;
use App\Http\Controllers\SuggestController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::redirect('/', '/login');

Route::prefix('/')->middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/signIn', [AuthController::class, 'signIn'])->name('signIn');
    Route::post('/forgot', [AuthController::class, 'forgot'])->middleware('guest')->name('password.request');
    Route::get('/reset/{token}', [AuthController::class, 'resetForm'])->middleware('guest')->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset'])->middleware('guest')->name('reset.post');
});

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/plans', PlanController::class);
    Route::resource('/physicalDocument', PhysicalDocument::class)->except('index', 'show', 'store', 'create', 'destroy');
    Route::resource('/documents', DocumentController::class);
    Route::resource('/organizations', OrganizationController::class);
    Route::resource('/supervisors', SupervisorController::class);
    Route::resource('/courses', CourseController::class);
    Route::resource('/suggests', SuggestController::class)->only(['index', 'destroy']);
    Route::post('/suggests/{id}/approve', [SuggestController::class, 'approve'])->name('suggests.approve');

    Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/profile', [UserController::class, 'storeProfile'])->name('users.storeProfile');

    Route::get('/plan/{id}/observes', [PlanController::class, 'observes'])->name('observes.create');
    Route::post('/observes/{id}', [PlanController::class, 'storeObserve'])->name('observes.store');
    Route::get('/observes/done/', [PlanController::class, 'doneObserves'])->name('observes.done');
    Route::get('/observes/{id}', [PlanController::class, 'showObserve'])->name('observes.show');
    Route::delete('/observes/{id}', [ObserveController::class, 'destroy'])->name('observes.remove');

    Route::prefix('import')->name('import.')->group(function () {
        Route::get('/plans', [ImportController::class, 'plansForm'])->name('plans.form');
        Route::post('/plans', [ImportController::class, 'plansStore'])->name('plans');

        Route::get('/addresses', [ImportController::class, 'addressesForm'])->name('addresses.form');
        Route::post('/addresses', [ImportController::class, 'addressesStore'])->name('addresses');

        Route::get('/areas', [ImportController::class, 'areasForm'])->name('areas.form');
        Route::post('/areas', [ImportController::class, 'areasStore'])->name('areas');
    });

    Route::prefix('export')->name('export.')->group(function () {
        Route::get('/duplicates', [ExportController::class, 'duplicates'])->name('duplicates');
        Route::get('/errors', [ExportController::class, 'errors'])->name('errors');

        Route::prefix('/address')->name('address.')->group(function () {
            Route::get('/notFounded', [ExportController::class, 'notFounded'])->name('notFounded');
            Route::get('/emptyNationalityCode', [ExportController::class, 'emptyNationalityCode'])->name('emptyNationalityCode');
        });

        Route::prefix('/areas')->name('areas.')->group(function () {
            Route::get('/notFounded', [ExportController::class, 'notFounded'])->name('notFounded');
            Route::get('/emptyNationalityCode', [ExportController::class, 'emptyNationalityCode'])->name('emptyNationalityCode');
        });
    });

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('report/13', Report13ControllerAlias::class)->name('report.13');
    Route::resource('problem',\App\Http\Controllers\ProblemController::class)->except('show');
    Route::resource('bank',\App\Http\Controllers\BankController::class)->except('show');
    Route::resource('branches',\App\Http\Controllers\BankBranchController::class)->except('show');
    Route::post('plans/report/problem/{id}',[\App\Http\Controllers\PlanController::class,'holdPlan'])->name('report.problem');
    Route::get('/supervisors-change/{id}',[\App\Http\Controllers\ChangeSupervisorController::class,'index'])->name('change-supervisor.index');
    Route::post('/supervisors-change/{id}',[\App\Http\Controllers\ChangeSupervisorController::class,'store'])->name('change-supervisor.store');
    Route::get('/remove_cache', function () {
        if (!auth()->user()->isAdmin)
            abort(403);
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        return redirect()->back();
    })->name('remove-cache');
});

Route::post('/upload', function (Request $request) {
    foreach ($request->file('image') as $image) {
        $name = Str::uuid();
        $image->move(public_path('uploads'));
    }
})->name('upload');
/*
Route::get('/test', function () {
    $files = scandir(public_path('uploads'));
    $prefix = public_path('uploads') . "/";
    $types = \App\Models\Document::all();
    foreach ($files as $file) {
        if (\App\Models\Image::where('url', $file)->first() || !is_file($prefix . $file))
            continue;

        $file = $prefix . $file;

        $dateTime = date('Y-m-d H:i:s', filectime($file));
        $ten_min_before = \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->subMinutes(10);
        $ten_min_later = \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->addMinutes(10);
        $observes = \App\Models\Observe::whereBetween('created_at', [$ten_min_before, $ten_min_later])->get();
        if (count($observes) > 0) {
            $ex = explode('/', $file);


            $img = asset('uploads/' . end($ex));
            echo "<img height='250' width='250' src='$img'><br>";
            foreach ($observes as $observe) {
                $links = "";
                foreach ($types as $type) {
                    if (!\App\Models\Image::where([['plan_id', $observe->plan_id],['document_id',$type->id]])->first()){
                        $links .= "
                        <a target='_blank' href='" . \route("setFile", ['file' => end($ex), 'plan' => $observe->plan_id, 'type' => $type->id]) . "'>
                        $type->title
                        </a>
                        |
                        
                        ";
                    }

                }
                echo "
                    {$observe->plan->title} | 
                    $links
                    
                    <br>
                    ";
            }
            echo "<hr>";
        }

    }
});
Route::get('setFile/{file}/{plan}/{type}', function ($file, $plan, $type) {

    \App\Models\Image::create([
        'url' => $file,
        'document_id' => $type,
        'plan_id' => $plan
    ]);
    return "<script>window.close()</script>";
})->name('setFile');
*/