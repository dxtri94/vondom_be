<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVondomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // roles table
        Schema::dropIfExists('roles');
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role', 255);
        });
        
        // users table
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 255);
            $table->string('password', 255);
            $table->integer('role_id')->unsigned();
            
            //            foreign to roles
             $table->foreign('role_id')
                 ->references('id')
                 ->on('roles')
                 ->onDelete('cascade');
        });
        
        // categories table
        Schema::dropIfExists('categories');
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->default(NULL);
            $table->timestamps();
        });
        
        // collections table
        Schema::dropIfExists('collections');
        Schema::create('collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categories_id')->unsigned();
            $table->string('name', 255)->nullable()->default(NULL);
            $table->string('image', 255)->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->timestamps();

//            foreign to categories
             $table->foreign('categories_id')
                 ->references('id')
                 ->on('categories')
                 ->onDelete('cascade');
        });

        // products table
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            //connect to collections
            $table->integer('collection_id')->unsigned();
            //connect to categories
            $table->integer('categories_id')->unsigned();
            $table->string('name', 255);
            $table->string('description', 255)->nullable()->default(NULL);
            $table->string('image', 255)->nullable()->default(NULL);
            $table->string('detail', 255)->nullable()->default(NULL);
            $table->timestamps();
            
            //foreign to categories
             $table->foreign('categories_id')
                 ->references('id')
                 ->on('categories')
                 ->onDelete('cascade');
            
            //foreign to platforms
             $table->foreign('collection_id')
                 ->references('id')
                 ->on('collections')
                 ->onDelete('cascade');
        });

        // tokens table
        Schema::dropIfExists('tokens');
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('token', 255);
            $table->dateTime('expired_at');
            $table->boolean('is_remember')->default(true);
            $table->integer('timezone')->default(0);
            $table->timestamps();

            //foreign to users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // confirm_tokens table
        Schema::dropIfExists('confirm_tokens');
        Schema::create('confirm_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('token', 255);
            $table->dateTime('expired_at');
            $table->timestamps();

            //foreign to users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // catalogs table
        Schema::dropIfExists('catalogs');
        Schema::create('catalogs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->default(NULL);
            $table->string('main_img', 255)->nullable()->default(NULL);
            $table->string('sub_img', 255)->nullable()->default(NULL);
            $table->string('link', 255)->nullable()->default(NULL);
            $table->text('description')->nullable()->default(NULL);
            $table->timestamps();
        });

        // news table
        Schema::dropIfExists('news');
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable()->default(NULL);
            $table->text('content', 255)->nullable()->default(NULL);
            $table->string('image')->nullable()->default(NULL);
            $table->string('location')->nullable()->default(NULL);
            $table->timestamps();
        });

        // user_contacts table
        Schema::dropIfExists('user_contacts');
        Schema::create('user_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable()->default(NULL);
            $table->text('phone', 255)->nullable()->default(NULL);
            $table->string('address')->nullable()->default(NULL);
            $table->string('mail')->nullable()->default(NULL);
            $table->string('title')->nullable()->default(NULL);
            $table->string('content')->nullable()->default(NULL);
            $table->timestamps();
        });
            
        // contacts table
        Schema::dropIfExists('contacts');
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image', 255)->nullable()->default(NULL);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
        Schema::drop('categories');
        Schema::drop('collections');
        Schema::drop('news');
        Schema::drop('catalogs');
        Schema::drop('confirm_tokens');
        Schema::drop('tokens');
        Schema::drop('roles');
        Schema::drop('users');
        Schema::drop('contacts');
        Schema::drop('user_contacts');
    }
}
