<?php
/**
 * Controller for Password table
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
 * CreatePasswordResetsTable Class
 *
 * @category  Controller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class CreatePasswordResetsTable extends Migration
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
            'password_resets',
            function (Blueprint $table) {
                $table->string('email')->index();
                $table->string('token');
                $table->timestamp('created_at')
                    ->nullable();
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
        Schema::dropIfExists('password_resets');
    }
}
