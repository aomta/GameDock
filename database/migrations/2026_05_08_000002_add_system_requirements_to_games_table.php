<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->text('os_minimum')->nullable()->after('release_date');
            $table->text('processor_minimum')->nullable()->after('os_minimum');
            $table->text('memory_minimum')->nullable()->after('processor_minimum');
            $table->text('graphics_minimum')->nullable()->after('memory_minimum');
            $table->text('storage_minimum')->nullable()->after('graphics_minimum');
            $table->text('os_recommended')->nullable()->after('storage_minimum');
            $table->text('processor_recommended')->nullable()->after('os_recommended');
            $table->text('memory_recommended')->nullable()->after('processor_recommended');
            $table->text('graphics_recommended')->nullable()->after('memory_recommended');
            $table->text('storage_recommended')->nullable()->after('graphics_recommended');
        });
    }

    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['os_minimum', 'processor_minimum', 'memory_minimum', 'graphics_minimum', 'storage_minimum', 'os_recommended', 'processor_recommended', 'memory_recommended', 'graphics_recommended', 'storage_recommended']);
        });
    }
};
