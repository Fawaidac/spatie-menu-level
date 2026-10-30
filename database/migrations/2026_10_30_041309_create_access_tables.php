<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $t) {
            $t->id();
            $t->string('nama')->unique();
            $t->boolean('is_system')->default(false);
            $t->timestamps();
        });

        Schema::create('menus', function (Blueprint $t) {
            $t->id();
            $t->foreignId('parent_id')->nullable()->constrained('menus')->restrictOnDelete();
            $t->string('kode_menu', 20)->unique();
            $t->string('nama');
            $t->string('url')->default('#');
            $t->string('icon')->nullable();
            $t->unsignedInteger('urutan')->default(0);
            $t->timestamps();
        });

        Schema::create('level_menu', function (Blueprint $t) {
            $t->foreignId('level_id')->constrained()->cascadeOnDelete();
            $t->foreignId('menu_id')->constrained()->cascadeOnDelete();
            $t->boolean('can_view')->default(false);
            $t->boolean('can_add')->default(false);
            $t->boolean('can_edit')->default(false);
            $t->boolean('can_del')->default(false);
            $t->primary(['level_id', 'menu_id']);
        });

        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('level_id')->nullable()->after('password')->constrained('levels')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->dropConstrainedForeignId('level_id');
        });
        Schema::dropIfExists('level_menu');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('levels');
    }
};
