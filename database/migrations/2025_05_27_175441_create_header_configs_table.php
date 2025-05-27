<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('header_configs')) {
            Schema::create('header_configs', function (Blueprint $table) {
                $table->id();
                $table->string('background_color')->default('#ffffff');
                $table->string('header_color')->default('rgba(255,255,255,0.9)');
                $table->string('button_color')->default('#28a745');
                $table->string('hover_color')->default('#218838');
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();

                $table->foreign('updated_by')
                      ->references('id_usuario')
                      ->on('usuarios')
                      ->onDelete('set null');
            });

            DB::table('header_configs')->insert([
                'background_color' => '#ffffff',
                'header_color'     => 'rgba(255,255,255,0.9)',
                'button_color'     => '#28a745',
                'hover_color'      => '#218838',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('header_configs');
    }
};