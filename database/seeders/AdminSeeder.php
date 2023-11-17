<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        # Create at least 2 sample admin users here

        $this->user->name       = 'Administrator';
        $this->user->email      = 'admin@gmail.com';
        $this->user->password   = Hash::make('admin111');
        $this->user->role_id    = User::ADMIN_ROLE_ID; //1
        $this->user->save();
    }

}
