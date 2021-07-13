<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/','App\Http\Controllers\HomeController@index');

    // Compañia
    Route::get('/companias/selectCompany','App\Http\Controllers\HomeController@selectCompany');
    Route::get('/companias', 'App\Http\Controllers\CompaniaController@index');
    Route::get('/companias/new', 'App\Http\Controllers\CompaniaController@new');
    Route::get('/companias/edit/{id}', 'App\Http\Controllers\CompaniaController@edit');
    Route::get('/companias/delete/{id}', 'App\Http\Controllers\CompaniaController@prepare');
    Route::post('/companias/create', 'App\Http\Controllers\CompaniaController@store')->name('CreateCompany');
    Route::put('/companias/update/{id}', 'App\Http\Controllers\CompaniaController@update')->name('UpdateCompany');
    Route::post('/companias/delete/{id}', 'App\Http\Controllers\CompaniaController@delete')->name('DeleteCompany');

    // Areas
    Route::get('/areas','App\Http\Controllers\AreaController@index');
    Route::get('/areas/new', 'App\Http\Controllers\AreaController@new');
    Route::get('/areas/edit/{id}', 'App\Http\Controllers\AreaController@edit');
    Route::get('/areas/delete/{id}', 'App\Http\Controllers\AreaController@prepare');
    Route::post('/areas/create', 'App\Http\Controllers\AreaController@store')->name('CreateArea');
    Route::put('/areas/update/{id}', 'App\Http\Controllers\AreaController@update')->name('UpdateArea');
    Route::post('/areas/delete/{id}', 'App\Http\Controllers\AreaController@delete')->name('DeleteArea');

    //Puestos
    Route::get('/puesto', 'App\Http\Controllers\PuestosController@index');
    Route::get('/puesto/new', 'App\Http\Controllers\PuestosController@new');
    Route::get('/puesto/edit/{id}', 'App\Http\Controllers\PuestosController@edit');
    Route::get('/puesto/delete/{id}', 'App\Http\Controllers\PuestosController@prepare');
    Route::post('/puesto/create', 'App\Http\Controllers\PuestosController@store')->name('CreatePuesto');
    Route::put('/puesto/update/{id}', 'App\Http\Controllers\PuestosController@update')->name('UpdatePuesto');
    Route::post('/puesto/delete/{id}', 'App\Http\Controllers\PuestosController@delete')->name('DeletePuesto');

    //Estados
    Route::get('/estados', 'App\Http\Controllers\StatusController@index');
    Route::get('/estados/new', 'App\Http\Controllers\StatusController@new');
    Route::get('/estados/edit/{id}', 'App\Http\Controllers\StatusController@edit');
    Route::get('/estados/delete/{id}', 'App\Http\Controllers\StatusController@prepare');
    Route::post('/estados/create', 'App\Http\Controllers\StatusController@store')->name('CreateStatus');
    Route::put('/estados/update/{id}', 'App\Http\Controllers\StatusController@update')->name('UpdateStatusStatus');
    Route::post('/estados/delete/{id}', 'App\Http\Controllers\StatusController@delete')->name('DeleteStatus');

    //RASIC
    Route::get('/roles-RASIC', 'App\Http\Controllers\RolesRASICController@index');

    //Indicadores
    Route::get('/indicadores', 'App\Http\Controllers\IndicadorController@index');
    Route::get('/indicadores/new', 'App\Http\Controllers\IndicadorController@new');
    Route::get('/indicadores/edit/{id}', 'App\Http\Controllers\IndicadorController@edit');
    Route::get('/indicadores/delete/{id}', 'App\Http\Controllers\IndicadorController@prepare');
    Route::post('/indicadores/create', 'App\Http\Controllers\IndicadorController@store')->name('CreateIndicator');
    Route::put('/indicadores/update/{id}', 'App\Http\Controllers\IndicadorController@update')->name('UpdateIndicator');
    Route::post('/indicadores/delete/{id}', 'App\Http\Controllers\IndicadorController@delete')->name('DeleteIndicator');

    //Enfoques
    Route::get('/enfoques', 'App\Http\Controllers\EnfoquesController@index');
    Route::get('/enfoques/new', 'App\Http\Controllers\EnfoquesController@new');
    Route::get('/enfoques/edit/{id}', 'App\Http\Controllers\EnfoquesController@edit');
    Route::get('/enfoques/delete/{id}', 'App\Http\Controllers\EnfoquesController@prepare');
    Route::post('/enfoques/create', 'App\Http\Controllers\EnfoquesController@store')->name('CreateFocus');
    Route::put('/enfoques/update/{id}', 'App\Http\Controllers\EnfoquesController@update')->name('UpdateFocus');
    Route::post('/enfoques/delete/{id}', 'App\Http\Controllers\EnfoquesController@delete')->name('DeleteFocus');

    //Usuarios
    Route::get('/usuarios', 'App\Http\Controllers\UsuariosController@index');
    Route::get('/usuarios/new', 'App\Http\Controllers\UsuariosController@new');
    Route::get('/usuarios/edit/{id}', 'App\Http\Controllers\UsuariosController@edit');
    Route::get('/usuarios/delete/{id}', 'App\Http\Controllers\UsuariosController@prepare');
    Route::post('/usuarios/create', 'App\Http\Controllers\UsuariosController@store')->name('CreateUser');
    Route::put('/usuarios/update/{id}', 'App\Http\Controllers\UsuariosController@update')->name('UpdateUser');
    Route::post('/usuarios/delete/{id}', 'App\Http\Controllers\UsuariosController@delete')->name('DeleteUser');
    Route::get('/usuarios/change-company/{id}', 'App\Http\Controllers\UsuariosController@changeCompany');
    Route::get('/usuarios/ChangeSend/{id}','App\Http\Controllers\UsuariosController@editSend');
    Route::put('/usuarios/UpdateSend/{id}','App\Http\Controllers\UsuariosController@updateSend')->name('UpdateSend');

    //Patrocinadores
    Route::get('/patrocinadores', 'App\Http\Controllers\SponsorsController@index');
    Route::get('/patrocinadores/new', 'App\Http\Controllers\SponsorsController@new');
    Route::get('/patrocinadores/edit/{id}', 'App\Http\Controllers\SponsorsController@edit');
    Route::get('/patrocinadores/delete/{id}', 'App\Http\Controllers\SponsorsController@prepare');
    Route::post('/patrocinadores/create', 'App\Http\Controllers\SponsorsController@store')->name('CreateSponsor');
    Route::put('/patrocinadores/update/{id}', 'App\Http\Controllers\SponsorsController@update')->name('UpdateSponsor');
    Route::post('/patrocinadores/delete/{id}', 'App\Http\Controllers\SponsorsController@delete')->name('DeleteSponsor');

    //Fases
    Route::get('/fases', 'App\Http\Controllers\FasesController@index');
    Route::get('/fases/new', 'App\Http\Controllers\FasesController@new');
    Route::get('/fases/edit/{id}', 'App\Http\Controllers\FasesController@edit');
    Route::get('/fases/delete/{id}', 'App\Http\Controllers\FasesController@prepare');
    Route::post('/fases/create', 'App\Http\Controllers\FasesController@store')->name('CreateFase');
    Route::put('/fases/update/{id}', 'App\Http\Controllers\FasesController@update')->name('UpdateFase');
    Route::post('/fases/delete/{id}', 'App\Http\Controllers\FasesController@delete')->name('DeleteFase');

    //Etapas
    Route::get('/etapas', 'App\Http\Controllers\EtapasController@index');
    Route::get('/etapas/new', 'App\Http\Controllers\EtapasController@new');
    Route::get('/etapas/edit/{id}', 'App\Http\Controllers\EtapasController@edit');
    Route::get('/etapas/delete/{id}', 'App\Http\Controllers\EtapasController@prepare');
    Route::post('/etapas/create', 'App\Http\Controllers\EtapasController@store')->name('CreateEtapa');
    Route::put('/etapas/update/{id}', 'App\Http\Controllers\EtapasController@update')->name('UpdateEtapa');
    Route::post('/etapas/delete/{id}', 'App\Http\Controllers\EtapasController@delete')->name('DeleteEtapa');
    Route::get('/etapas/Prepare','App\Http\Controllers\EtapasController@preparePdf')->name('FiltersStages');
    Route::post('/etapas/PDF','App\Http\Controllers\EtapasController@exportPdf')->name('StagesPDF');

    //Roles
    Route::get('/roles', 'App\Http\Controllers\RolesController@index');
    Route::get('/roles/new', 'App\Http\Controllers\RolesController@new');
    Route::get('/roles/edit/{id}', 'App\Http\Controllers\RolesController@edit');
    Route::post('/roles/create', 'App\Http\Controllers\RolesController@create');
    Route::post('/roles/update', 'App\Http\Controllers\RolesController@update');
    Route::post('/roles/delete/{id}', 'App\Http\Controllers\RolesController@delete');

    //Proyectos
    Route::get('/proyectos', 'App\Http\Controllers\ProyectosController@index');
    Route::get('/proyectos/new','App\Http\Controllers\ProyectosController@new');
    Route::get('/proyectos/ChangeStage/{id}','App\Http\Controllers\ProyectosController@editStage');
    Route::get('/proyectos/ChangeStatus/{id}','App\Http\Controllers\ProyectosController@editStatus');
    Route::post('/proyectos/create','App\Http\Controllers\ProyectosController@store')->name('CreateProject');
    Route::put('/proyectos/UpdateStage/{id}','App\Http\Controllers\ProyectosController@updateStage')->name('UpdateStage');
    Route::put('/proyectos/UpdateStatus/{id}','App\Http\Controllers\ProyectosController@updateStatus')->name('UpdateStatus');
    Route::get('/proyectos/area-users', 'App\Http\Controllers\ProyectosController@getUsers');
    Route::get('/proyectos/prepare','App\Http\Controllers\ProyectosController@preparePdf')->name('FiltersProjects');
    Route::post('/proyectos/PDF','App\Http\Controllers\ProyectosController@exportPdf')->name('ProjectsPDF');
    Route::get('/mis-proyectos', 'App\Http\Controllers\ProyectosController@index');


    //Actividades
    Route::get('/actividades', 'App\Http\Controllers\ActividadesController@index');
    Route::get('/actividades/type/{id}', 'App\Http\Controllers\ActividadesController@type')->name('TypeActivity');
    Route::get('/actividades/new/{proyectoID}', 'App\Http\Controllers\ActividadesController@new')->name('NewActivity');
    Route::get('/actividades/edit/{id}', 'App\Http\Controllers\ActividadesController@edit');
    Route::post('/actividades/create', 'App\Http\Controllers\ActividadesController@store')->name('CreateActivity');
    Route::post('/actividades/update', 'App\Http\Controllers\ActividadesController@update');
    Route::post('/actividades/delete/{id}', 'App\Http\Controllers\ActividadesController@delete');
    Route::get('/actividades/ChangeStatus/{id}','App\Http\Controllers\ActividadesController@editStatus');
    Route::put('/actividades/UpdateStatus/{id}','App\Http\Controllers\ActividadesController@updateStatus')->name('UpdateStatusActivity');
    Route::get('/actividades/prepare','App\Http\Controllers\ActividadesController@preparePdf')->name('FiltersActivities');
    Route::post('/actividades/PDF','App\Http\Controllers\ActividadesController@exportPdf')->name('ActivitiesPDF');

    //roles en Proyectos
    Route::get('/roles-proyectos', 'App\Http\Controllers\RolesProyectosController@index');
    Route::get('/roles-proyectos/new', 'App\Http\Controllers\RolesProyectosController@new')->name('NewProjectUser');
    Route::get('/roles-proyectos/Select', 'App\Http\Controllers\RolesProyectosController@select')->name('Select');
    Route::post('/roles-proyectos/create', 'App\Http\Controllers\RolesProyectosController@store')->name('CreateProjectUser');
    Route::get('/roles-proyectos/ChangeStatus/{id}','App\Http\Controllers\RolesProyectosController@editStatus');
    Route::put('/roles-proyectos/UpdateStatus/{id}','App\Http\Controllers\RolesProyectosController@updateStatus')->name('UpdateStatusProjectUser');
    Route::get('/roles-proyectos/prepare','App\Http\Controllers\RolesProyectosController@preparePdf')->name('FiltersUsersProjects');
    Route::post('/roles-proyectos/PDF','App\Http\Controllers\RolesProyectosController@exportPdf')->name('UsersProjectsPDF');

    //Trabajos
    Route::get('/trabajos', 'App\Http\Controllers\TrabajosController@index');
    Route::get('/trabajos/new', 'App\Http\Controllers\TrabajosController@new');
    Route::get('/trabajos/edit/{id}', 'App\Http\Controllers\TrabajosController@edit');
    Route::post('/trabajos/create', 'App\Http\Controllers\TrabajosController@create');
    Route::post('/trabajos/update', 'App\Http\Controllers\TrabajosController@update');
    Route::post('/trabajos/delete/{id}', 'App\Http\Controllers\TrabajosController@delete');

    //Graficas
    Route::get('/graficas/proyectos', 'App\Http\Controllers\GraficasController@toProjects')->name('ChartsProjects');
    Route::get('/graficas/actividades', 'App\Http\Controllers\GraficasController@toActivities')->name('ChartsActivities');

    //Roles en Fases
    Route::get('/roles-fases', 'App\Http\Controllers\RolesFaseController@index');
    Route::get('/roles-fases/new', 'App\Http\Controllers\RolesFaseController@new');
    Route::get('/roles-fases/edit/{id}', 'App\Http\Controllers\RolesFaseController@edit');
    Route::post('/roles-fases/create', 'App\Http\Controllers\RolesFaseController@create');
    Route::post('/roles-fases/update', 'App\Http\Controllers\RolesFaseController@update');
    Route::post('/roles-fases/delete/{id}', 'App\Http\Controllers\RolesFaseController@delete');

    //Reportes
    Route::get('/reportes/actividades-empresa-por-enfoque', 'App\Http\Controllers\ReportesController@ActividadesEmpresaPorEnfoque');
    Route::get('/reportes/proyectos', 'App\Http\Controllers\ReportesController@proyectos');
    Route::get('/reportes/recursos', 'App\Http\Controllers\ReportesController@recursosPorRoles');
    Route::get('/reportes/actividades-empresa-por-estado', 'App\Http\Controllers\ReportesController@ActividadesEmpresaPorStatus');

    //Envio de Correos
    Route::get('/email/usuarios','App\Http\Controllers\EmailController@index');
    Route::get('/email/send-reporte-asignaciones-por-estado','App\Http\Controllers\EmailController@SendReporteAsignacionesEnfoque');
    Route::get('/email/send','App\Http\Controllers\EmailController@send');
});

