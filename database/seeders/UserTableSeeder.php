<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if($this->command->confirm("Do you want to refresh the database ?") ){
            $this->command->call("migrate:refresh");
            $this->command->info("database was refreshede !!");

        }

        
        $nbUsers = (int)$this->command->ask("How many of user you want generate ?", 10);
         User::factory($nbUsers)->create();
    }
}
