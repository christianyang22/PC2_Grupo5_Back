<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Tabla: roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('Id_rol');
            $table->string('Nombre')->unique();
        });

        // 2. Tabla: usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('Id_usuario');
            $table->string('Usuario')->unique();
            $table->string('Hashed_password');
            $table->string('Email')->unique();
            // Se declara como nullable para permitir ON DELETE SET NULL
            $table->unsignedInteger('Rol')->nullable()->default(1);
            $table->string('Nombre');
            $table->string('Apellido');
            $table->date('Fecha_nacimiento')->nullable();
            $table->timestamp('Fecha_creacion')->useCurrent();

            // Restricción de clave foránea
            $table->foreign('Rol')
                ->references('Id_rol')
                ->on('roles')
                ->onDelete('set null');
        });

        // 3. Tabla: productos
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('Id_producto');
            $table->string('Nombre');
            $table->text('Enlace');
            $table->text('Link_imagen')->nullable();
            // Usamos decimal para valores monetarios
            $table->decimal('Precio', 10, 2);
            // Oferta: 0 = No, 1 = Sí
            $table->integer('Oferta')->default(0);
            $table->decimal('Precio_peso', 10, 2)->nullable();
            $table->decimal('Grasas', 5, 2)->nullable();
            $table->decimal('Grasas_saturadas', 5, 2)->nullable();
            $table->decimal('Hidratos_carbono', 5, 2)->nullable();
            $table->decimal('Azucar', 5, 2)->nullable();
            $table->decimal('Proteina', 5, 2)->nullable();
            $table->decimal('Sal', 5, 2)->nullable();
            $table->decimal('Valoracion', 3, 2)->nullable();
            $table->string('Supermercado');
            $table->integer('Cluster')->nullable();

            // Nota: Las restricciones CHECK no se añaden automáticamente en Laravel.
        });

        // 4. Tabla: historial_sesiones
        Schema::create('historial_sesiones', function (Blueprint $table) {
            $table->increments('Id_historial');
            $table->unsignedInteger('Id_usuario');
            $table->timestamp('Fecha_de_sesion')->useCurrent();

            $table->foreign('Id_usuario')
                ->references('Id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
        });

        // 5. Tabla: favoritos
        Schema::create('favoritos', function (Blueprint $table) {
            $table->increments('Id_favorito');
            $table->unsignedInteger('Id_producto');
            $table->unsignedInteger('Id_usuario');

            $table->foreign('Id_producto')
                ->references('Id_producto')
                ->on('productos')
                ->onDelete('cascade');

            $table->foreign('Id_usuario')
                ->references('Id_usuario')
                ->on('usuarios')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Se eliminan las tablas en orden inverso
        Schema::dropIfExists('favoritos');
        Schema::dropIfExists('historial_sesiones');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
