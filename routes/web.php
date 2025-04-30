<?php

use App\Http\Controllers\AssigneeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClientBillController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\CourierPaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FleetController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PasarJayaShipmentController;
use App\Http\Controllers\PaxelShipmentController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use App\Models\ClientBill;
use Illuminate\Support\Facades\Route;





Route::middleware(['guest.role'])->group(function () {
  Route::get('/', [AuthController::class, 'index'])->name('login.index');
  // Route::get('/login', [AuthController::class, 'index'])->name('login.index');
  Route::post('/login', [AuthController::class, 'login'])->name('login.auth');
});

Route::prefix('admin')->name("admin.")->group(function () {
  Route::middleware(['web', 'auth'])->group(
    function () {
      // Akses hanya admin
      Route::get("/dashboard", [DashboardController::class, 'index_shipping'])->name("shippings.index")->middleware('role:admin');
      Route::get("/dashboard/shippings", [DashboardController::class, 'index_shipping'])->name("shippings.index")->middleware('role:admin');
      Route::get("/dashboard/couriers", [DashboardController::class, 'index_courier'])->middleware('role:admin');
      Route::resource("/prices", PriceController::class)->middleware('role:admin');
      Route::resource("/users", UserController::class)->middleware('role:admin');
      Route::get("/courier-payments", [CourierPaymentController::class, 'index'])->name("courier-payments.index")->middleware('role:admin');
      Route::get("/courier-payments/{display_data}/{date}/edit", [CourierPaymentController::class, 'edit'])->name("courier-payments.edit")->middleware('role:admin');
      Route::put("/courier-payments/{date}/{courier_ID}", [CourierPaymentController::class, 'update'])->name("courier-payments.update")->middleware('role:admin');
      Route::resource("/client-bills", ClientBillController::class)->middleware('role:admin');

      Route::resource("/couriers", CourierController::class)->middleware('role:admin,korlap');
      Route::resource("/fleets", FleetController::class)->middleware('role:admin,korlap');
      // Route::resource("/locations", LocationController::class)->middleware('role:admin,korlap');
      // Route::resource("/assignees", AssigneeController::class)->middleware('role:admin,korlap');
      // Route::resource("/paxel-shippings", PaxelShipmentController::class)->parameters([
      //   'paxel-shippings' => 'paxelShipment'
      // ])->middleware('role:admin,korlap');
      // Route::resource("/pasjay-shippings", PasarJayaShipmentController::class)->parameters([
      //   'pasjay-shippings' => 'pasarJayaShipment'
      // ])->middleware('role:admin,korlap');
    }
  );



  Route::middleware(['auth', 'web', 'role:admin,korlap'])->group(function () {

    // Locations
    Route::get('/locations/create', [LocationController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');

    // Assignees
    Route::get('/assignees/create', [AssigneeController::class, 'create'])->name('assignees.create');
    Route::post('/assignees', [AssigneeController::class, 'store'])->name('assignees.store');
    Route::delete('/assignees/{assignee}', [AssigneeController::class, 'destroy'])->name('assignees.destroy');

    // Paxel Shippings
    Route::get('/paxel-shippings/create', [PaxelShipmentController::class, 'create'])->name('paxel-shippings.create');
    Route::post('/paxel-shippings', [PaxelShipmentController::class, 'store'])->name('paxel-shippings.store');
    Route::delete('/paxel-shippings/{paxelShipment}', [PaxelShipmentController::class, 'destroy'])->name('paxel-shippings.destroy');

    // Pasjay Shippings
    Route::delete('/pasjay-shippings/{pasarJayaShipment}', [PasarJayaShipmentController::class, 'destroy'])->name('pasjay-shippings.destroy');
  });

  Route::middleware(['auth', 'web', 'role:admin,korlap,kurir'])->group(function () {


    // Locations
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/{location}', [LocationController::class, 'show'])->name('locations.show');

    // Assignees
    Route::get('/assignees', [AssigneeController::class, 'index'])->name('assignees.index');
    Route::get('/assignees/{assignee}', [AssigneeController::class, 'show'])->name('assignees.show');
    Route::get('/assignees/{assignee}/edit', [AssigneeController::class, 'edit'])->name('assignees.edit');
    Route::put('/assignees/{assignee}', [AssigneeController::class, 'update'])->name('assignees.update');

    // Paxel Shippings
    Route::get('/paxel-shippings', [PaxelShipmentController::class, 'index'])->name('paxel-shippings.index');
    Route::get('/paxel-shippings/{paxelShipment}', [PaxelShipmentController::class, 'show'])->name('paxel-shippings.show');
    Route::get('/paxel-shippings/{paxelShipment}/edit', [PaxelShipmentController::class, 'edit'])->name('paxel-shippings.edit');
    Route::put('/paxel-shippings/{paxelShipment}', [PaxelShipmentController::class, 'update'])->name('paxel-shippings.update');

    // Pasjay Shippings
    Route::get('/pasjay-shippings', [PasarJayaShipmentController::class, 'index'])->name('pasjay-shippings.index');
    Route::get('/pasjay-shippings/create', [PasarJayaShipmentController::class, 'create'])->name('pasjay-shippings.create');
    Route::post('/pasjay-shippings', [PasarJayaShipmentController::class, 'store'])->name('pasjay-shippings.store');
    Route::get('/pasjay-shippings/{pasarJayaShipment}', [PasarJayaShipmentController::class, 'show'])->name('pasjay-shippings.show');
    Route::get('/pasjay-shippings/{pasarJayaShipment}/edit', [PasarJayaShipmentController::class, 'edit'])->name('pasjay-shippings.edit');
    Route::put('/pasjay-shippings/{pasarJayaShipment}', [PasarJayaShipmentController::class, 'update'])->name('pasjay-shippings.update');

    // Route Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  });
});
