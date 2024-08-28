<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropColumn('post_id');
            
            // I CAN NOT ADD SOFTDELETES METHOD ON MORPH HER I WILL ADD IT IN IMAGE MODEL
            $table->morphs('imageable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('images', function (Blueprint $table) {
         $table->dropMorphs('imageable');
         $table->foreignId('post_id')->constrained()->onDelete('cascade');
         
        });
    }
};
