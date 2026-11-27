<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
        });

        DB::table('genders')->insert([
            ['name' => 'Мужской'],
            ['name' => 'Женский'],
        ]);

        // name -> fio (данные существующих пользователей сохраняются)
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'fio');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('fio', 150)->change();
            $table->date('birthday')->nullable()->after('fio');
            $table->foreignId('gender_id')->nullable()->after('birthday')->constrained('genders');
            $table->softDeletes();
        });

        // у уже существующих пользователей пол не задан — ставим первый, затем делаем поле обязательным
        DB::table('users')->whereNull('gender_id')->update([
            'gender_id' => DB::table('genders')->min('id'),
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('gender_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropColumn(['birthday', 'gender_id', 'deleted_at']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('fio', 'name');
        });

        Schema::dropIfExists('genders');
    }
};
