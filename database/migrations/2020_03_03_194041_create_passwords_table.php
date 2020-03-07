<?php

use App\Http\RoutesInfo\V1\PasswordInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwords', static function (Blueprint $table) {
            $table->bigIncrements(PasswordInfo::Id);
            $table->unsignedBigInteger(PasswordInfo::UserId);
            $table->string(PasswordInfo::Username);
            $table->string(PasswordInfo::Value);
            $table->string(PasswordInfo::Website);
            $table->string(PasswordInfo::Name)->nullable();
            $table->text(PasswordInfo::Note)->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('passwords');
    }
}
