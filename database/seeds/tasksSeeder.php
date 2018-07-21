<?php

use Illuminate\Database\Seeder;

class tasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('tasks')->insert([
            'name'          => str_random(15),
            'done'          => 0,
            'created_at'     => now(),
            'updated_at'    => now(),
        ]);  
    }
}
