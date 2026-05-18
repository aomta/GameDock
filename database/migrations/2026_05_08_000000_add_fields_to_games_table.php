<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('developer')->nullable()->after('genre');
            $table->string('publisher')->nullable()->after('developer');
            $table->date('release_date')->nullable()->after('publisher');
            $table->string('slug')->unique()->nullable()->after('title');
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['developer', 'publisher', 'release_date', 'slug']);
        });
    }
};
