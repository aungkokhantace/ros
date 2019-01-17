<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDbBackupToConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('config', function($table) {
            $table->string('backup_url')->after('remark')->nullable();
            $table->integer('backup_frequency')->after('remark')->nullable();
            $table->string('db_name')->after('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('config', function($table) {
            $table->dropColumn('backup_url');
            $table->dropColumn('backup_frequency');
            $table->dropColumn('db_name');
        });
    }
}
