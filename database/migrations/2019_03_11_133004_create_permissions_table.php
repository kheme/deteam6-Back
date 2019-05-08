<?php
/**
 * Controller for Permissions table
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
 * CreatePermissionsTable Class
 *
 * @category  Controller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class CreatePermissionsTable extends Migration
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
            'permissions',
            function (Blueprint $table) {
                $table->bigInteger('id', true)->unsigned();
                $table->string('name', 64);
                $table->timestamps();
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
        Schema::dropIfExists('permissions');
    }
}
