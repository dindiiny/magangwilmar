<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabController;
use App\Http\Controllers\FlowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController as LabCtrl;

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

// Public Routes
Route::get('/check-storage', function() {
    try {
        // 1. Check URL generation
        $url = Illuminate\Support\Facades\Storage::disk('public')->url('test.jpg');
        
        // 2. Try to write a file
        $testContent = 'Hello Supabase ' . now();
        $writeSuccess = Illuminate\Support\Facades\Storage::disk('public')->put('test-upload.txt', $testContent);
        
        // 3. Try to list files
        $files = Illuminate\Support\Facades\Storage::disk('public')->files();
        
        return [
            'status' => 'success',
            'write_success' => $writeSuccess,
            'generated_url' => $url,
            'files_count' => count($files),
            'first_5_files' => array_slice($files, 0, 5),
            'config_bucket' => config('filesystems.disks.public.bucket'),
            'config_endpoint' => config('filesystems.disks.public.endpoint'),
            'env_endpoint_raw' => env('AWS_ENDPOINT'),
            'env_url_raw' => env('AWS_URL'), // Add this to debug
            'computed_endpoint' => config('filesystems.disks.public.endpoint'),
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'config_bucket' => config('filesystems.disks.public.bucket'),
            'config_endpoint' => config('filesystems.disks.public.endpoint'),
            'env_endpoint_raw' => env('AWS_ENDPOINT'),
            'env_url_raw' => env('AWS_URL'), // Add this to debug
        ];
    }
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/laboratorium', [LabController::class, 'index'])->name('laboratorium');
Route::get('/flow-proses', [FlowController::class, 'index'])->name('flow');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dokumen-laporan', [DocumentController::class, 'index'])->name('documents.index');

    // Admin Resources (CRUD)
    
    // Team Members
    Route::post('/team-members', [HomeController::class, 'storeTeam'])->name('team.store');
    Route::put('/team-members/{id}', [HomeController::class, 'updateTeam'])->name('team.update');
    Route::delete('/team-members/{id}', [HomeController::class, 'destroyTeam'])->name('team.destroy');

    // Structure
    Route::post('/structure', [HomeController::class, 'storeStructure'])->name('structure.store');

    // Page Content
    Route::put('/page-content', [HomeController::class, 'updateContent'])->name('page.content.update');

    // Lab Equipment
    Route::post('/lab-equipment', [LabController::class, 'storeEquipment'])->name('equipment.store');
    Route::put('/lab-equipment/{id}', [LabController::class, 'updateEquipment'])->name('equipment.update');
    Route::delete('/lab-equipment/{id}', [LabController::class, 'destroyEquipment'])->name('equipment.destroy');

    // Products
    Route::post('/products', [LabController::class, 'storeProduct'])->name('product.store');
    Route::put('/products/{id}', [LabController::class, 'updateProduct'])->name('product.update');
    Route::delete('/products/{id}', [LabController::class, 'destroyProduct'])->name('product.destroy');

    // SOP Pengujian
    Route::post('/sops', [LabController::class, 'storeSOP'])->name('sop.store');
    Route::put('/sops/{id}', [LabController::class, 'updateSOP'])->name('sop.update');
    Route::delete('/sops/{id}', [LabController::class, 'destroySOP'])->name('sop.destroy');

    // Seven S (Admin only)
    Route::post('/seven-s', [LabCtrl::class, 'storeSevenS'])->name('sevens.store');

    // Process Flows
    Route::post('/process-flows', [FlowController::class, 'storeFlow'])->name('flow.store');
    Route::put('/process-flows/{id}', [FlowController::class, 'updateFlow'])->name('flow.update');
    Route::delete('/process-flows/{id}', [FlowController::class, 'destroyFlow'])->name('flow.destroy');

    // Documents (Admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::put('/documents/{id}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    });
});

// Admin / Auth Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
