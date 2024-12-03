<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tf_teamflow_attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable'); 
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('media_type'); // e.g., 'image', 'pdf', etc.
            $table->string('media_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tf_teamflow_attachments');
    }
};