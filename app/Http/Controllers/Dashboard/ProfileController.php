<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $countries = Countries::getNames();
        $locales = Languages::getNames();

        return view("dashboard.profile.edit", compact("user", "countries", "locales"));
    }
    public function update(Request $request)
    {
        $request->validate([
            "frist_name" => ["required", "string", "max:255"],
            "last_name" => ["required", "string", "max:255"],
            "birthday" => ['nullable', 'date', 'before:today'],
            "gender" => ['in:male,female'],
            "country" => ["required", "string", "max:2"],
            "locale" => ['nullable']
        ]);

        $user = $request->user();
        $user->profile->fill($request->all())->save();
        return redirect()->route("dashboard.profile.edit")->with("success", "profile update!");
    }
}
