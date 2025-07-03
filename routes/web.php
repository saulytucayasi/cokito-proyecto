<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\VideoController;

// Admin Controllers
use App\Http\Controllers\Admin\AcademiaController;
use App\Http\Controllers\Admin\CicloController;
use App\Http\Controllers\Admin\CursoController as AdminCursoController;
use App\Http\Controllers\Admin\EstudianteController as AdminEstudianteController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\MatriculaController as AdminMatriculaController;
use App\Http\Controllers\Admin\TrabajadorController;
use App\Http\Controllers\UsuarioController;

// Secretaria Controllers
use App\Http\Controllers\Secretaria\MatriculaController as SecretariaMatriculaController;
use App\Http\Controllers\Secretaria\EstudianteController as SecretariaEstudianteController;
use App\Http\Controllers\Secretaria\PagoController;
use App\Http\Controllers\Secretaria\CursoController as SecretariaCursoController;
use App\Http\Controllers\Secretaria\MaterialController as SecretariaMaterialController;

// Docente Controllers
use App\Http\Controllers\Docente\CursoController as DocenteCursoController;
use App\Http\Controllers\Docente\MaterialController as DocenteMaterialController;
use App\Http\Controllers\Docente\EstudianteController as DocenteEstudianteController;
use App\Http\Controllers\Docente\VideoController as DocenteVideoController;

// Estudiante Controllers
use App\Http\Controllers\Estudiante\CursoController as EstudianteCursoController;
use App\Http\Controllers\Estudiante\MaterialController as EstudianteMaterialController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('academias', AcademiaController::class);
    Route::resource('ciclos', CicloController::class);
    Route::resource('cursos', AdminCursoController::class);
    Route::resource('estudiantes', AdminEstudianteController::class);
    Route::resource('materiales', AdminMaterialController::class);
    Route::resource('matriculas', AdminMatriculaController::class);
    Route::resource('trabajadores', TrabajadorController::class)->parameters([
        'trabajadores' => 'trabajador'
    ]);
    Route::resource('usuarios', UsuarioController::class);
});

// Docente Routes
Route::middleware(['auth', 'role:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', [DocenteController::class, 'dashboard'])->name('dashboard');
    Route::resource('cursos', DocenteCursoController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('materiales', DocenteMaterialController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/materiales/curso/{curso}', [DocenteMaterialController::class, 'index'])->name('materiales.por-curso');
    Route::resource('videos', DocenteVideoController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/videos/curso/{curso}', [DocenteVideoController::class, 'verVideosPorCurso'])->name('videos.por-curso');
    Route::get('/estudiantes', [DocenteEstudianteController::class, 'index'])->name('estudiantes.index');
    Route::get('/estudiantes/curso/{curso}', [DocenteEstudianteController::class, 'index'])->name('estudiantes.por-curso');
    Route::get('/estudiantes/{estudiante}', [DocenteEstudianteController::class, 'show'])->name('estudiantes.show');
    Route::post('/estudiantes/calificar', [DocenteEstudianteController::class, 'calificar'])->name('estudiantes.calificar');
});

// Secretaria Routes
Route::middleware(['auth', 'role:secretaria'])->prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('/dashboard', [SecretariaController::class, 'dashboard'])->name('dashboard');
    Route::resource('matriculas', SecretariaMatriculaController::class);
    Route::resource('estudiantes', SecretariaEstudianteController::class);
    Route::resource('pagos', PagoController::class);
    Route::resource('cursos', SecretariaCursoController::class)->only(['index', 'show']);
    Route::resource('materiales', SecretariaMaterialController::class)->only(['index', 'show']);
});

// Estudiante Routes
Route::middleware(['auth', 'role:estudiante'])->prefix('estudiante')->name('estudiante.')->group(function () {
    Route::get('/dashboard', [EstudianteController::class, 'dashboard'])->name('dashboard');
    Route::get('/cursos', [EstudianteCursoController::class, 'index'])->name('cursos.index');
    Route::get('/cursos/{curso}', [EstudianteCursoController::class, 'show'])->name('cursos.show');
    Route::get('/materiales', [EstudianteMaterialController::class, 'index'])->name('materiales.index');
    Route::get('/materiales/{material}', [EstudianteMaterialController::class, 'show'])->name('materiales.show');
});

// Material Routes (compartidas entre roles) - These might need to be adjusted or removed if specific role-based material controllers are preferred.
// For now, keeping them as they were, but consider if they overlap with Admin/Docente/Secretaria/Estudiante MaterialControllers.
Route::middleware('auth')->group(function () {
    Route::get('/materiales', [MaterialController::class, 'index'])->name('materiales.index');
    Route::get('/materiales/create', [MaterialController::class, 'create'])->name('materiales.create');
    Route::post('/materiales', [MaterialController::class, 'store'])->name('materiales.store');
    Route::get('/materiales/{id}/download', [MaterialController::class, 'download'])->name('materiales.download');
    Route::delete('/materiales/{id}', [MaterialController::class, 'destroy'])->name('materiales.destroy');
    Route::get('/materiales/curso/{cursoId}', [MaterialController::class, 'porCurso'])->name('materiales.por-curso');
});

// Video Routes (compartidas entre roles)
Route::middleware('auth')->group(function () {
    Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/create', [VideoController::class, 'create'])->name('videos.create');
    Route::post('/videos', [VideoController::class, 'store'])->name('videos.store');
    Route::get('/videos/{id}', [VideoController::class, 'show'])->name('videos.show');
    Route::get('/videos/{id}/edit', [VideoController::class, 'edit'])->name('videos.edit');
    Route::put('/videos/{id}', [VideoController::class, 'update'])->name('videos.update');
    Route::delete('/videos/{id}', [VideoController::class, 'destroy'])->name('videos.destroy');
    Route::get('/videos/curso/{cursoId}', [VideoController::class, 'porCurso'])->name('videos.por-curso');
});

// Fallback for authenticated users without specific role
Route::middleware('auth')->get('/dashboard', function () {
    return redirect('/login');
});