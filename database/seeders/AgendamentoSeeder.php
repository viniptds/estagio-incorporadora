<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Agendamento::factory(3)->create();
    }
}
