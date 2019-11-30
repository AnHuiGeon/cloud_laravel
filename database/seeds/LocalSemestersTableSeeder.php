<?php

use Illuminate\Database\Seeder;

class LocalSemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = App\User::all();

        $users->each(function ($user){
            $user->localSemesters()->save(
                factory(App\LocalSemester::class)->make()
            );
        });
    }
}
