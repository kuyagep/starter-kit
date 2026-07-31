<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $defaultSettings = [
            // General Meta Tags Config Mapping Contexts
            [
                'key' => 'app_name',
                'value' => 'Division Office Information System',
                'group' => 'general'
            ],
            [
                'key' => 'contact_email',
                'value' => 'helpdesk@masterdata.local',
                'group' => 'general'
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'group' => 'general'
            ],
            [
                'key' => 'allow_registration',
                'value' => '1',
                'group' => 'general'
            ],

            // Transport Mail Layer SMTP Mapping Contexts
            [
                'key' => 'mail_driver',
                'value' => 'smtp',
                'group' => 'mail'
            ],
            [
                'key' => 'mail_host',
                'value' => 'sandbox.smtp.mailtrap.io',
                'group' => 'mail'
            ],
            [
                'key' => 'mail_port',
                'value' => '2525',
                'group' => 'mail'
            ],
            [
                'key' => 'mail_username',
                'value' => 'demo_user_id',
                'group' => 'mail'
            ],
            [
                'key' => 'mail_password',
                'value' => 'demo_secret_pass',
                'group' => 'mail'
            ],
            [
                'key' => 'mail_from_address',
                'value' => 'noreply@systam.com',
                'group' => 'mail'
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
