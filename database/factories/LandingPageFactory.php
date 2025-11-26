<?php

namespace Database\Factories;

use App\Models\LandingPage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LandingPageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LandingPage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'descricao' => $this->faker->realText(),
            'endereco_completo' => $this->faker->realText(),
            'percentual_acompanhe_a_obra' => $this->faker->randomFloat(2, 0, 100),
            'texto_acompanhe_a_obra' => $this->faker->realText(),
            'cor_fundo' => $this->faker->hexColor(),
            'cor_texto' => $this->faker->hexColor(),
            "loteamento_id" => LoteamentoFactory::new(),
        ];
    }
}
