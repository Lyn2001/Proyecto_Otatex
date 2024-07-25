<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;

// Ruta para la página de inicio
Route::get('/', [HomeController::class, 'home'])->name('home.index');

// Ruta para el dashboard principal
Route::get('/dashboard', [HomeController::class, 'login_home'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para mis órdenes
Route::get('/myorders', [HomeController::class, 'myorders'])
    ->middleware(['auth', 'verified']);

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación
require __DIR__.'/auth.php';

// Rutas del panel de administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('view_category', [AdminController::class, 'view_category']);
    Route::post('add_category', [AdminController::class, 'add_category']);
    Route::get('delete_category/{id}', [AdminController::class, 'delete_category']);
    Route::get('edit_category/{id}', [AdminController::class, 'edit_category']);
    Route::post('update_category/{id}', [AdminController::class, 'update_category']);
    Route::get('add_product', [AdminController::class, 'add_product']);
    Route::post('upload_product', [AdminController::class, 'upload_product']);
    Route::get('view_product', [AdminController::class, 'view_product']);
    Route::get('delete_product/{id}', [AdminController::class, 'delete_product']);
    Route::get('update_product/{id}', [AdminController::class, 'update_product']);
    Route::post('edit_product/{id}', [AdminController::class, 'edit_product']);
    Route::get('product_search', [AdminController::class, 'product_search']);
    Route::get('view_orders', [AdminController::class, 'view_orders']);
    Route::get('on_the_way/{id}', [AdminController::class, 'on_the_way']);
    Route::get('delivered/{id}', [AdminController::class, 'delivered']);
    Route::get('print_pdf/{id}', [AdminController::class, 'print_pdf']);
    //aqui tambien cambie 
    Route::get('view_user', [AdminController::class, 'view_user'])->name('view_user');;
    //Nueva ruta para añadir usuario
    Route::get('add_user', [AdminController::class, 'add_user']);
    // Ruta para manejar el envío del formulario y almacenar el usuario (POST)
    Route::post('upload_user', [AdminController::class, 'upload_user']);
    //
    Route::get('delete_user/{id}', [AdminController::class, 'delete_user']);
    Route::get('edit_user/{id}', [AdminController::class, 'edit_user']);
    Route::post('update_user/{id}', [AdminController::class, 'update_user']);
    Route::get('view_rol', [AdminController::class, 'view_rol']);
    Route::post('add_rol', [AdminController::class, 'add_rol']);
    Route::get('delete_role/{id}', [AdminController::class, 'delete_role']);
    Route::get('edit_role/{id}', [AdminController::class, 'edit_role']); // Ruta para mostrar el formulario de edición
    Route::post('update_role/{id}', [AdminController::class, 'update_role']); 
    //Rutas Permisos
    // Mostrar permisos
    Route::get('view_permissions', [AdminController::class, 'view_permissions'])->name('view_permissions');
    // Agregar permiso
    Route::post('add_permission', [AdminController::class, 'add_permission']);
    Route::get('edit_permission/{id}', [AdminController::class, 'edit_permission']);
    Route::put('update_permission/{id}', [AdminController::class, 'update_permission']);
    Route::get('delete_permission/{id}', [AdminController::class, 'delete_permission']);

    //Asiganr y eliminar permisos
    Route::get('manage_roles_permissions', [AdminController::class, 'manage_roles_permissions']);
    Route::post('assign_permissions/{roleId}', [AdminController::class, 'assign_permissions']);
    Route::delete('remove_permission/{roleId}/{permissionId}', [AdminController::class, 'remove_permission']);

    //descomentar esto si no funciona lo de abajo
    // //Ruta unica index para ver auditoria
    // Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    // Route::get('/user/firstname/{id}', [UserController::class, 'getUserFirstName'])->name('user.firstname');
    //Ruta para el tema de maestro detalle de venta
    Route::resource('/ventas', App\Http\Controllers\VentaController::class);
    Route::get('ventas_search', [App\Http\Controllers\VentaController::class, 'search'])->name('ventas.search');

});


//Aumentado esta parte si en caso de que no funcione lo quitamos y descomentamos lo de arriba
// Rutas para el auditor
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('/audits/dashboard', [AuditController::class, 'dashboard'])->name('audits.dashboard');
    Route::get('/user/firstname/{id}', [UserController::class, 'getUserFirstName'])->name('user.firstname');
});
//

// Otras rutas para usuarios y visitantes
Route::get('product_details/{id}', [HomeController::class, 'product_details']);
Route::get('add_cart/{id}', [HomeController::class, 'add_cart'])
    ->middleware(['auth', 'verified']);
Route::get('mycart', [HomeController::class, 'mycart'])
    ->middleware(['auth', 'verified']);
Route::get('logout', [HomeController::class, 'logout'])
    ->middleware(['auth', 'verified']);
Route::get('delete_cart/{id}', [HomeController::class, 'delete_cart'])
    ->middleware(['auth', 'verified']);
Route::post('confirm_order', [HomeController::class, 'confirm_order'])
    ->middleware(['auth', 'verified']);
Route::get('shop', [HomeController::class, 'shop']);
Route::get('why', [HomeController::class, 'why']);
Route::get('testimonial', [HomeController::class, 'testimonial']);
Route::get('contact2', [HomeController::class, 'contact2']);
