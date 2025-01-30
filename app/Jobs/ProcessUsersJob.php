<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProcessUsersJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public $users;
    public $timeout = 60;
    public $tries = 3;
    protected $page;

    /**
     * Create a new job instance.
     */
    public function __construct($page)
    {
        $this->page = $page;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         // Ambil data pengguna untuk halaman yang diberikan
        //  $users = User::with('rolesAndPermissions')->where('page', $this->page)->get()->paginate(50, ['*'], 'page', $this->page);
        $users = User::with('rolesAndPermissions')->paginate(50, ['*'], 'page', $this->page);
        Log::info($users);


         // Simpan data halaman ke cache
         Cache::put('users_page_' . $this->page, $users, 3600);

    }
}
