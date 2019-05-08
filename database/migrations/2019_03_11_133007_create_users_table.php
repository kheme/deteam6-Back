<?php
/**
 * Controller for Users table
 * 
 * PHP version 7
 *
 * @category  Controller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * CreateUsersTable Class
 *
 * @category  Controller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @author Okiemute Omuta <omuta.okiemute@gmail.com>
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'users',
            function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->bigInteger('role_id')->unsigned()->index();
                $table->string('name');
                $table->string('email')->nullable()->unique();
                $table->string('password');
                $table->timestamp('email_verified_at')->nullable();
                $table->rememberToken();
                $table->timestamps();
            }
        );

        Schema::table(
            'users',
            function (Blueprint $table) {
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     * 
     * @author Okiemute Omuta <omuta.okiemute@gmail.com>
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
