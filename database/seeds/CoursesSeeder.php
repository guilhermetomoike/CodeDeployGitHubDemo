<?php

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class)->createMany([
            ['name' => 'Medicina'],
            ['name' => 'Enfermagem'],
            ['name' => 'Farmácia'],
            ['name' => 'Fisioterapia'],
            ['name' => 'Odontologia'],
            ['name' => 'Biomedicina'],
        ]);
    }
}
