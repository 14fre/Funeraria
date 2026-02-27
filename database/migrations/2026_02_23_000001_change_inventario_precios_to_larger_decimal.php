<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE inventario MODIFY precio_compra DECIMAL(14, 2) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE inventario MODIFY precio_venta DECIMAL(14, 2) NOT NULL DEFAULT 0');
        } else {
            DB::statement('ALTER TABLE inventario ALTER COLUMN precio_compra TYPE DECIMAL(14, 2), ALTER COLUMN precio_compra SET DEFAULT 0');
            DB::statement('ALTER TABLE inventario ALTER COLUMN precio_venta TYPE DECIMAL(14, 2), ALTER COLUMN precio_venta SET DEFAULT 0');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE inventario MODIFY precio_compra DECIMAL(10, 2) NOT NULL DEFAULT 0');
            DB::statement('ALTER TABLE inventario MODIFY precio_venta DECIMAL(10, 2) NOT NULL DEFAULT 0');
        } else {
            DB::statement('ALTER TABLE inventario ALTER COLUMN precio_compra TYPE DECIMAL(10, 2), ALTER COLUMN precio_compra SET DEFAULT 0');
            DB::statement('ALTER TABLE inventario ALTER COLUMN precio_venta TYPE DECIMAL(10, 2), ALTER COLUMN precio_venta SET DEFAULT 0');
        }
    }
};
