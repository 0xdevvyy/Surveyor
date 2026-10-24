<?php

use App\Models\Barangay;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('households', function (Blueprint $table) {
            $table->uuid('id')->primary(); // will be the private id
            $table->string('household_number'); // will be the public id that visible to all, if my php package is finish this can be the qr code link
            $table->foreignUuidFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Barangay::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('households');
    }
};
