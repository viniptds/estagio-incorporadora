<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoteamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loteamentos = \App\Models\Loteamento::factory(3)->create();

        foreach ($loteamentos as $lt) {
            \App\Models\LandingPage::factory()->create(['loteamento_id' => $lt->id]);
        }
    }
}
