<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Computer;
use App\Models\Issue;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Sinh 20 máy tính trước
        Computer::factory(20)->create();

        // 2. Sinh 50 sự cố (Issues) 
        // Vì trong IssueFactory mình đã code logic lấy random computer_id rồi
        // nên ở đây chỉ cần gọi create() là xong.
        Issue::factory(50)->create();
    }
}
