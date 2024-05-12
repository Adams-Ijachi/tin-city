<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('vehicle_type');
            $table->string('group_name');

            $table->string('vehicle_Id')->unique();
            $table->string('device_Id')->unique();

            $table->index(['group_name','vehicle_Id']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};
