<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tf_teamflow_notes', function (Blueprint $table) {
            $table->id();
            $table->morphs('notable');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('type')->default('note'); // 'note' or 'message'
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tf_teamflow_notes');
    }
};