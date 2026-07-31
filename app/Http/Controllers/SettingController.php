<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        // Pluck key-value arrays to make them easy to inject inside form values
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $rules = [
            // General Properties
            'app_name'           => 'required|string|max:255',
            'contact_email'      => 'required|email',
            'maintenance_mode'   => 'nullable|in:0,1',
            'allow_registration' => 'nullable|in:0,1',

            // SMTP Configurations Matrix
            'mail_driver'        => 'nullable|string|max:50',
            'mail_host'          => 'nullable|string|max:255',
            'mail_port'          => 'nullable|integer',
            'mail_username'      => 'nullable|string|max:255',
            'mail_password'      => 'nullable|string|max:255',
            'mail_from_address'  => 'nullable|email',
        ];

        $validated = $request->validate($rules);

        // Safely loop keys and synchronize tracking properties
        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $this->getGroup($key)]
            );
        }

        // CRITICAL STEP: Evict obsolete runtime cache instantly
        Cache::forget('global_system_settings');

        return response()->json([
            'success' => true,
            'message' => 'System settings configurations compiled and cache matrix updated.'
        ]);
    }

    private function getGroup($key)
    {
        if (str_starts_with($key, 'mail_')) {
            return 'mail';
        }
        return 'general';
    }
}
