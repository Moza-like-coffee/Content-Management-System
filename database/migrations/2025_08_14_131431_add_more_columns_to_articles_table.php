<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('content');
            $table->text('excerpt')->nullable()->after('content');
            $table->string('image_alt')->nullable()->after('image');
            $table->string('meta_title')->nullable()->after('image_alt');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->timestamp('published_at')->nullable()->after('updated_at');
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'excerpt',
                'image_alt',
                'meta_title',
                'meta_description',
                'published_at'
            ]);
        });
    }
};