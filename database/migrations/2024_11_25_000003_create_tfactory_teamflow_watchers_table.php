<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tfactory_teamflow_watchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->morphs('watchable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tfactory_teamflow_watchers');
    }
};