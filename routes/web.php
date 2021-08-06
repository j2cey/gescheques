<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ArisController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\MimeTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BordereauController;
use App\Http\Controllers\CustomLdapController;
use App\Http\Controllers\WorkflowExecController;
use App\Http\Controllers\WorkflowStepController;
use App\Http\Controllers\EncaissementController;
use App\Http\Controllers\WorkflowActionController;
use App\Http\Controllers\WorkflowObjectController;
use App\Http\Controllers\WorkflowExecActionController;
use App\Http\Controllers\WorkflowActionTypeController;
use App\Http\Controllers\WorkflowObjectFieldController;
use App\Http\Controllers\WorkflowExecModelStepController;

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
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Route::get('/home', function () {
    if (Auth::check()) {
        return view('admin02');
    }
    return redirect('/login');
});

Auth::routes();

Route::prefix('ldap')->group(function(){
    Route::get('/test', [CustomLdapController::class,'test'])->name('ldaptest');
    Route::get('/sync', [CustomLdapController::class,'sync'])->name('ldapsync');
});

// Route pour test de Master/Details avec Vuejs et VueX
Route::get('persons', [PersonController::class,'index']);

#region product

Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/product/fetch', [ProductController::class, 'fetch'])->name('product.fetch');
Route::get('/product/{product_id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::get('/product/{product_id}/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

#endregion

#region permissions & roles

Route::get('permissions',[RoleController::class, 'permissions'])->middleware('auth');

Route::resource('roles',RoleController::class)->middleware('auth');
Route::get('roles.fetch',[RoleController::class,'fetch'])
    ->name('roles.fetch')
    ->middleware('auth');
Route::get('hasrole/{roleid}',[RoleController::class, 'hasrole'])->middleware('auth');

#endregion

#region workflows

Route::resource('workflows',WorkflowController::class)->middleware('auth');
Route::get('workflows.fetch',[WorkflowController::class,'fetch'])
    ->name('workflows.fetch')
    ->middleware('auth');

#endregion

#region workflowsteps

Route::resource('workflowsteps',WorkflowStepController::class)->middleware('auth');
Route::get('workflowsteps.fetchbyworkflow/{id}',[WorkflowStepController::class, 'fetchbyworkflow'])
    ->name('workflowsteps.fetchbyworkflow')
    ->middleware('auth');

#endregion

#region workflowactions

Route::resource('workflowactions',WorkflowActionController::class)->middleware('auth');
Route::get('workflowactions.fetchbystep/{id}',[WorkflowActionController::class, 'fetchbystep'])
    ->name('workflowactions.fetchbystep')
    ->middleware('auth');

#endregion

#region workflowactiontypes & mimetypes

Route::resource('workflowactiontypes',WorkflowActionTypeController::class)->middleware('auth');
Route::get('workflowactiontypes.fetch',[WorkflowActionTypeController::class, 'fetch'])
    ->name('workflowactiontypes.fetch')
    ->middleware('auth');
Route::resource('mimetypes',MimeTypeController::class)->middleware('auth');
Route::get('mimetypes.fetch',[MimeTypeController::class, 'fetch'])
    ->name('mimetypes.fetch')
    ->middleware('auth');

#endregion

Route::resource('files',FileController::class)->middleware('auth');
Route::get('files.previewpdf/{filename}',[FileController::class, 'previewpdf'])
    ->name('files.previewpdf')
    ->middleware('auth');

#endregion

#region workflowobjects & workflowobjectfields

Route::resource('workflowobjects',WorkflowObjectController::class)->middleware('auth');
Route::resource('workflowobjectfields',WorkflowObjectFieldController::class)->middleware('auth');

#endregion

#region workflowexecs & workflowexecactions

Route::resource('workflowexecs',WorkflowExecController::class)->middleware('auth');
Route::resource('workflowexecactions',WorkflowExecActionController::class)->middleware('auth');

#endregion

#region workflowexecmodelsteps & canexecstep & actionstoexec

Route::resource('workflowexecmodelsteps', WorkflowExecModelStepController::class)->middleware('auth');
Route::get('canexecstep/{stepid}', [WorkflowExecModelStepController::class,'canexecstep'])->middleware('auth');
Route::post('actionstoexec', [WorkflowExecModelStepController::class,'actionstoexec'])->middleware('auth');

#endregion

//Route::get('/home', 'HomeController@index')->name('home');

Route::resource('settings',SettingController::class);

Route::get('dashboards',[DashboardController::class,'index'])
    ->name('dashboards.index')
    ->middleware('auth');
Route::get('dashboards/fetch',[DashboardController::class,'fetch'])
    ->name('dashboards.fetch')
    ->middleware('auth');
Route::get('dashboards/fetchagence/{id}',[DashboardController::class,'fetchagence'])
    ->name('dashboards.fetchagence')
    ->middleware('auth');

Route::resource('cheques',ChequeController::class)->middleware('auth');
Route::get('cheques.upload',[ChequeController::class,'upload'])
    ->name('cheques.upload')
    ->middleware('auth');
Route::post('cheques.uploadpost',[ChequeController::class,'uploadpost'])
    ->name('cheques.uploadpost')
    ->middleware('auth');
Route::get('cheques.fetch',[ChequeController::class,'fetch'])
    ->name('cheques.fetch')
    ->middleware('auth');

#region encaissements

Route::resource('encaissements',EncaissementController::class)->middleware('auth');
Route::get('encaissements.upload',[EncaissementController::class,'upload'])
    ->name('encaissements.upload')
    ->middleware('auth');
Route::post('encaissements.uploadpost',[EncaissementController::class,'uploadpost'])
    ->name('encaissements.uploadpost')
    ->middleware('auth');
Route::get('encaissements.fetch',[EncaissementController::class,'fetch'])
    ->name('encaissements.fetch')
    ->middleware('auth');

#endregion

Route::resource('bordereaus',BordereauController::class)->middleware('auth');
Route::get('bordereaus.fetch',[BordereauController::class,'fetch'])
    ->name('bordereaus.fetch')
    ->middleware('auth');

Route::resource('users',UserController::class)->middleware('auth');
Route::get('users.fetch',[UserController::class,'fetch'])
    ->name('users.fetch')
    ->middleware('auth');
Route::get('users.fetchall',[UserController::class,'fetchall'])
    ->name('users.fetchall')
    ->middleware('auth');

Route::get('aris.getchequeinfos/{ref}',[ArisController::class,'getchequeinfos'])
    ->name('aris.getchequeinfos')
    ->middleware('auth');
