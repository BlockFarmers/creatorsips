<?php

namespace Azuriom\Plugin\CreatorsIps\Http\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function show()
    {
        return view('creatorsips::admin.settings', [
            'token' => $this->currentToken(),
            'siteUrl' => rtrim(url('/'), '/'),
            'endpoint' => route('creatorsips.api.join'),
            'activeDays' => (int) setting('creatorsips.active_days', 7),
            'minecraftPluginUrl' => config('creatorsips.minecraft_plugin_url'),
        ]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'active_days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        Setting::updateSettings(['creatorsips.active_days' => $validated['active_days']]);

        return to_route('creatorsips.admin.settings')
            ->with('success', trans('creatorsips::admin.settings.saved'));
    }

    public function regenerateToken()
    {
        Setting::updateSettings(['creatorsips.token' => Str::random(48)]);

        return to_route('creatorsips.admin.settings')
            ->with('success', trans('creatorsips::admin.settings.token_regenerated'));
    }

    private function currentToken(): string
    {
        $token = setting('creatorsips.token');

        if (empty($token)) {
            $token = Str::random(48);
            Setting::updateSettings(['creatorsips.token' => $token]);
        }

        return $token;
    }
}
