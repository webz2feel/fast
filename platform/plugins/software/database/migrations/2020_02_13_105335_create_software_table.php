<?php

use Fast\ACL\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('software_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('parent_id')->unsigned()->default(0);
            $table->string('description', 400)->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('icon', 60)->nullable();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_default')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('software_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('description', 400)->nullable()->default('');
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
        Schema::create('software_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('description', 400)->nullable()->default('');
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
        Schema::create('software_compatibilities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('description', 400)->nullable()->default('');
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
        Schema::create('software_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->string('description', 400)->nullable()->default('');
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });

        Schema::create('softwares', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('description', 400)->nullable();
            $table->text('content')->nullable();
            $table->string('status', 60)->default('published');
            $table->integer('author_id');
            $table->string('author_type', 255)->default(addslashes(User::class));
            $table->tinyInteger('is_featured')->unsigned()->default(0);
            $table->string('image', 255)->nullable();
            $table->integer('views')->unsigned()->default(0);
            $table->string('format_type', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('software_tags_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id')->unsigned()->references('id')->on('software_tags')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->references('id')->on('softwares')->onDelete('cascade');
        });

        Schema::create('software_categories_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->references('id')->on('software_categories')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->references('id')->on('softwares')->onDelete('cascade');
        });
        Schema::create('software_system_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_id')->unsigned()->references('id')->on('software_systems')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->references('id')->on('softwares')->onDelete('cascade');
        });
        Schema::create('software_compatibility_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('compatibility_id')->unsigned()->references('id')->on('software_compatibilities')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->references('id')->on('softwares')->onDelete('cascade');
        });
        Schema::create('software_language_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('language_id')->unsigned()->references('id')->on('software_languages')->onDelete('cascade');
            $table->integer('software_id')->unsigned()->references('id')->on('softwares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('software_tags');
        Schema::dropIfExists('software_categories');
        Schema::dropIfExists('software_system_pivot');
        Schema::dropIfExists('software_compatibility_pivot');
        Schema::dropIfExists('software_language_pivot');
        Schema::dropIfExists('softwares');
        Schema::dropIfExists('software_categories_pivot');
        Schema::dropIfExists('software_tags_pivot');
        Schema::dropIfExists('software_systems');
        Schema::dropIfExists('software_compatibilities');
        Schema::dropIfExists('software_languages');
    }
}
