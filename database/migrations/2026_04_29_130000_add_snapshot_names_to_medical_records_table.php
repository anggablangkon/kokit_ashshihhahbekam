<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->string('patient_name')->nullable()->after('patient_id');
            $table->string('employee_name')->nullable()->after('employee_id');
        });

        DB::table('medical_records')
            ->orderBy('id')
            ->get()
            ->each(function ($record): void {
                $patientName = DB::table('patients')->where('id', $record->patient_id)->value('name');
                $employeeName = DB::table('users')->where('id', $record->employee_id)->value('name');

                DB::table('medical_records')
                    ->where('id', $record->id)
                    ->update([
                        'patient_name' => $patientName,
                        'employee_name' => $employeeName,
                    ]);
            });
    }

    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            $table->dropColumn(['patient_name', 'employee_name']);
        });
    }
};
