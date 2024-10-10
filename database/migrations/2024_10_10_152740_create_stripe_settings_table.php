<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStripeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->text('STRIPE_KEY')->nullable();
            $table->text('STRIPE_SECRET')->nullable();
            $table->foreignId('business_id')
            ->constrained('garages')
            ->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('system_settings')
        ->insert(array(
           [
            "self_registration_enabled" => 0,
            "STRIPE_KEY" => NULL,
            "STRIPE_SECRET" => NULL,
           ],
        ));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stripe_settings');
    }
}
