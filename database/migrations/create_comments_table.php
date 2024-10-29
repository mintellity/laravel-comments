<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('comment_id')->primary();

            // Polymorphic relation to the model that gets commented
            $table->uuidMorphs('modelable'); // UUID and Model Type

            // Polymorphic relation to the entity that made the comment
            $table->uuidMorphs('userable'); // UUID and Model Type
            $table->text('comment_content')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};