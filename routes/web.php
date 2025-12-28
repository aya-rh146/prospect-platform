<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProspectController; // زد هاد السطر

// Route لتسجيل الـ prospects من الـ home page
Route::post('/', [ProspectController::class, 'store'])->name('prospects.store');

// الـ home page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Login routes للـ modal
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'Les identifiants fournis sont incorrects.',
    ])->withInput();
});

// Logout
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/prospects', [App\Http\Controllers\Admin\ProspectController::class, 'index'])->name('admin.prospects.index');
    Route::get('/prospects/{id}/edit', [App\Http\Controllers\Admin\ProspectController::class, 'edit'])->name('admin.prospects.edit');
    Route::put('/prospects/{id}', [App\Http\Controllers\Admin\ProspectController::class, 'update'])->name('admin.prospects.update');
    Route::delete('/prospects/{id}', [App\Http\Controllers\Admin\ProspectController::class, 'destroy'])->name('admin.prospects.destroy');
    Route::get('/prospects/export', [App\Http\Controllers\Admin\ProspectController::class, 'export'])->name('admin.prospects.export');
    Route::get('/admin/prospects', [App\Http\Controllers\Admin\ProspectController::class, 'index'])->name('admin.prospects');
    Route::delete('/admin/prospects/{prospect}', [App\Http\Controllers\Admin\ProspectController::class, 'destroy'])->name('admin.prospects.destroy');   
    // Route للـ polling ديال الـ new leads (notification toast + sound)
    Route::get('/check-new-leads', function () {
        $lastId = request('last_id', 0);

        $newLeads = \App\Models\Prospect::where('id', '>', $lastId)
                    ->orderBy('id', 'asc')
                    ->get([
                        'id',
                        'full_name as name',
                        'phone_number as phone'
                    ]);

        return response()->json([
            'new_leads' => $newLeads,
            'latest_id' => $newLeads->max('id') ?? $lastId,
        ]);
    })->name('check.new.leads');

});

require __DIR__.'/auth.php';