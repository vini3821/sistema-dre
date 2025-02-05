<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('sectors')) {
            throw new \Exception('A tabela sectors precisa existir antes de adicionar a chave estrangeira.');
        }

        Schema::table('servicos', function (Blueprint $table) {
            if (!Schema::hasColumn('servicos', 'sector_id')) {
                $table->unsignedBigInteger('sector_id')->nullable();
                $table->foreign('sector_id')
                      ->references('id')
                      ->on('sectors')
                      ->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('servicos', function (Blueprint $table) {
            $table->dropForeign(['sector_id']);
            $table->dropColumn('sector_id');
        });
    }
};