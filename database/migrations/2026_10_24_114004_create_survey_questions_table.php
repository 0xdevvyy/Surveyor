<?php

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
        // this is just the basic questions
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuidFor(User::class, 'surveyor_id')->constrained()->cascadeOnDelete();
            $table->foreignUuidFor(User::class, 'residents_id')->constrained()->cascadeOnDelete();
            // Household Information
            $table->unsignedInteger('household_size')->nullable();
            $table->string('relationship_to_household_head')->nullable();

            // Education and Employment
            $table->string('educational_attainment')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('occupation')->nullable();

            // Household Income
            $table->decimal('monthly_income', 10, 2)->nullable();

            // Housing and Utilities
            $table->string('housing_type')->nullable();
            $table->string('house_ownership')->nullable();
            $table->boolean('has_electricity')->nullable();
            $table->string('water_source')->nullable();
            $table->boolean('has_internet')->nullable();

            // Government Assistance
            $table->boolean('receives_government_assistance')->nullable();
            $table->boolean('is_4p_member')->nullable();
            $table->boolean('is_senior_beneficiary_member')->nullable();

            // Additional Information
            $table->text('other_concerns')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
