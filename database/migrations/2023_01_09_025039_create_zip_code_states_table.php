<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zip_code_states', function (Blueprint $table) {
            $table->id();
            $table->string('d_codigo')->nullable();
            $table->string('d_asenta')->nullable();
            $table->string('d_tipo_asenta')->nullable();
            $table->string('d_mnpio')->nullable();
            $table->string('d_estado')->nullable();
            $table->string('d_ciudad')->nullable();
            $table->string('d_cp')->nullable();
            $table->unsignedBigInteger('c_estado')->nullable();
            $table->string('c_oficina')->nullable();
            $table->string('c_cp')->nullable();
            $table->string('c_tipo_asenta')->nullable();
            $table->unsignedBigInteger('c_mnpio')->nullable();
            $table->unsignedBigInteger('id_asenta_cpcons')->nullable();
            $table->string('d_zona')->nullable();
            $table->string('c_cve_ciudad')->nullable();
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
        Schema::dropIfExists('zip_code_states');
    }
};
