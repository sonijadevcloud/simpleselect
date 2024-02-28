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
        DB::table('system_settings')->insert([
            [
                'name' => 'app_title',
                'description' => 'Application title displayed in browser window after application name',
                'value' => 'Your trusted parking sentinel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'app_timezone',
                'description' => 'Default time zone of the application, which will be taken into account when filling in the date/date and time fields in the application and database',
                'value' => 'Europe/Warsaw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'license_key',
                'description' => 'License key to use the application',
                'value' => '999-99-X9-99-2099-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'license_validity',
                'description' => 'Expiration date of the application license',
                'value' => '2099-12-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_name',
                'description' => 'Full name of the company or partnership',
                'value' => 'Sonija Dev Cloud Sp. z o.o.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_address',
                'description' => 'Address of the company`s headquarters',
                'value' => 'Zabłocona 8, 77-777 Błoto',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_phone',
                'description' => 'The main phone number for contacting the company',
                'value' => '666777333',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_email',
                'description' => 'The main email address for contacting the company',
                'value' => 'support@sonija.cloud',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_website',
                'description' => 'Link to the organization` website',
                'value' => 'https://sonija.cloud',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'company_logo_link',
                'description' => 'Link to the organization`s logo',
                'value' => 'https://sonija.cloud/galaxy/sonijadevcloud/img/SDC-LogoBlack-GreenIcon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('system_settings')->whereIn('name', [
            'app_title',
            'app_timezone',
            'license_key',
            'license_validity',
            'company_name',
            'company_address',
            'company_phone',
            'company_email',
            'company_website',
            'company_logo_link',
            ])->delete();
    }
};
