<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Jobs\ProcessUsersJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
        
        $start = microtime(true);
        // $users = User::with(['roles' ,'permissions'])->paginate(50, ['*'], 'page', request('page', 1));
        // $users = User::with(['role', 'permissions'])->paginate(50);
        $users = User::with(['roles.permissions'])->paginate(50);

        $end = microtime(true);
        $execution_time = ($end - $start);

         return view('users', [
            'users' => $users,
            'execution_time' => number_format($execution_time, 6). ' detik',
        ]);
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input (optional)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            // Validasi lainnya sesuai kebutuhan
        ]);

        // Update data pengguna
        $user = User::findOrFail($id);
        $user->update($validatedData);

        // Hapus cache terkait pengguna yang diubah, untuk halaman tertentu
        $page = request('page', 1); // Ambil parameter halaman
        Cache::forget('users_page_' . $page);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
