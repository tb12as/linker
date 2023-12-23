<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\UserSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Retrieves the user setting.
     *
     * @param Request $request The request object.
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException If the user is not logged in.
     * @return \Illuminate\Database\Eloquent\Collection The user setting with related user data.
     */
    public function userSetting(Request $request)
    {
        $user = $request->user();
        abort_if(!$user, 401, 'Dude, please login.');

        return Setting::with('user_setting')->get()
            ->map(function ($q) {
                $q->user_value = data_get($q, 'user_setting.value');
                return $q;
            });
    }

    /**
     * Sets a user setting based on the provided request.
     *
     * @param Request $request The request containing the setting ID and value.
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authenticated.
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the setting is not found.
     * @return UserSetting The saved user setting.
     */
    public function setSetting(Request $request)
    {
        $request->validate(['setting_id' => 'required', 'value' => 'required']);
        $user = $request->user();
        abort_if(!$user, 401, 'Dude, please login.');

        $setting = Setting::find($request->setting_id);
        abort_if(!$setting, 404, 'Setting not found');

        $us = UserSetting::where('setting_id', $setting->id)->first();
        $us = $us ?? new UserSetting();
        $us->setting_id = $setting->id;
        $us->user_id = $user->id;
        $us->value = $request->value;
        $us->save();

        return $us;
    }
}
