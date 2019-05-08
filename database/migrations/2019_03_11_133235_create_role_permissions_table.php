<?php
/**
 * Controller for Role Permissions table
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
 * CreateRolePermissionsTable Class
 *
 * @category  Controller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class CreateRolePermissionsTable extends Migration
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
            'role_permissions',
            function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->bigInteger('role_id')->unsigned();
                $table->bigInteger('permission_id')->unsigned();
                $table->timestamps();
            }
        );

        Schema::table(
            'role_permissions',
            function (Blueprint $table) {
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                
                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
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
        Schema::dropIfExists('role_permissions');
    }
}
