<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loteamentos', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 100);
            $table->string("descricao", 200);
            $table->string("link", 50)->unique();
            $table->decimal("area", 11,2);
            $table->boolean("status")->default(1);
            $table->foreignId("coordenada_id")->index()->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loteamentos');
    }
}
