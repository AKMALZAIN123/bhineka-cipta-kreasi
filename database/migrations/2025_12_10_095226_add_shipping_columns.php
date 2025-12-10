<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('nama_lengkap')->nullable()->after('status');
            $table->string('nomor_telepon')->nullable()->after('nama_lengkap');
            $table->string('email')->nullable()->after('nomor_telepon');
            $table->string('alamat_lengkap')->nullable()->after('email');
            $table->string('kecamatan', 20)->nullable()->after('alamat_lengkap');
            $table->string('kabupaten_kota')->nullable()->after('kecamatan');
            $table->text('provinsi')->nullable()->after('kabupaten_kota');
            $table->string('kode_pos', 100)->nullable()->after('provinsi');
            $table->string('catatan_pengiriman', 100)->nullable()->after('kode_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'nama_lengkap', 'nomor_telepon', 'email',
                'alamat_lengkap', 'kecamatan', 'kabupaten_kota',
                'provinsi', 'kode_pos', 'catatan_pengiriman',
            ]);
        });

    }
};
