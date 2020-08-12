<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DatabaseStudent::class);
    }
}

class DatabaseStudent extends Seeder
{
    public function run()
    {
        DB::table('students')->insert([
            ['name' => 'Nguyen Van Lam', 'address' => 'Bac Ninh', 'school' => 'bkhn'],
            ['name' => 'Nguyen Thanh An', 'address' => 'Ha Nam', 'school' => 'bkhn'],
            ['name' => 'Pham Cong Chinh', 'address' => 'Ha Noi', 'school' => 'Mo'],
            ['name' => 'Nguyen Nhu Hung', 'address' => 'Nghe An', 'school' => 'Cong nghe'],
            ['name' => 'Bui Van Cong', 'address' => 'Hue', 'school' => 'Mat ma'],
        ]);
    }
}
