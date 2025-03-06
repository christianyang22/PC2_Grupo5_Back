<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('hashed_password');
            $table->string('rol')->default('user'); // user, admin
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('enlace');
            $table->text('link_imagen')->nullable();
            $table->decimal('precio', 10, 2);
            $table->string('oferta')->nullable();
            $table->decimal('precio_peso', 10, 2)->nullable();
            $table->decimal('grasas', 5, 2)->nullable();
            $table->decimal('grasas_saturadas', 5, 2)->nullable();
            $table->decimal('hidratos_carbono', 5, 2)->nullable();
            $table->decimal('azucar', 5, 2)->nullable();
            $table->decimal('proteina', 5, 2)->nullable();
            $table->decimal('sal', 5, 2)->nullable();
            $table->decimal('valoracion', 3, 2)->default(0);
            $table->string('supermercado');
            $table->integer('cluster')->nullable();
            $table->timestamps();
        });

        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('products')->onDelete('cascade');
            $table->string('nombre_producto');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('favourites');
        Schema::dropIfExists('products');
        Schema::dropIfExists('users');
    }
};