<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // PostgreSQL specific optimizations
        
        // Add GIN indexes for JSON columns
        if (DB::connection()->getDriverName() === 'pgsql') {
            // First, ensure the column is jsonb (if it's not already)
            DB::statement('ALTER TABLE payment_logs ALTER COLUMN metadata TYPE jsonb USING metadata::jsonb');
            DB::statement('CREATE INDEX payment_logs_metadata_gin_idx ON payment_logs USING GIN (metadata)');
            
            // Create text search indexes for better search performance
            DB::statement('
                CREATE INDEX products_description_ts_idx ON products 
                USING GIN (to_tsvector(\'english\', description))
            ');
            
            // Create case-insensitive indexes for email
            DB::statement('CREATE INDEX users_email_ci_idx ON users (LOWER(email))');
            DB::statement('CREATE INDEX orders_customer_email_ci_idx ON orders (LOWER(customer_email))');
            
            // Create partial indexes
            DB::statement('
                CREATE INDEX orders_active_idx ON orders (status) 
                WHERE status IN (\'confirmed\', \'in_production\')
            ');
            
            // Create BRIN index for timestamp columns on large tables
            DB::statement('
                CREATE INDEX orders_created_at_brin_idx ON orders 
                USING BRIN (created_at)
            ');
        }
    }

    public function down()
    {
        if (DB::connection()->getDriverName() === 'pgsql') {
            DB::statement('DROP INDEX IF EXISTS payment_logs_metadata_gin_idx');
            DB::statement('DROP INDEX IF EXISTS products_description_ts_idx');
            DB::statement('DROP INDEX IF EXISTS users_email_ci_idx');
            DB::statement('DROP INDEX IF EXISTS orders_customer_email_ci_idx');
            DB::statement('DROP INDEX IF EXISTS orders_active_idx');
            DB::statement('DROP INDEX IF EXISTS orders_created_at_brin_idx');
             // Convert back to json if needed
        DB::statement('ALTER TABLE payment_logs ALTER COLUMN metadata TYPE json USING metadata::json');
        }
    }
};