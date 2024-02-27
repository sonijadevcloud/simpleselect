<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSettings;
use Auth;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $ss_app_title = SystemSettings::where('name', 'app_title')->first();
        $ss_license_key = SystemSettings::where('name', 'license_key')->first();
        $ss_license_validity = SystemSettings::where('name', 'license_validity')->first();
        $ss_company_name = SystemSettings::where('name', 'company_name')->first();
        $ss_company_address = SystemSettings::where('name', 'company_address')->first();
        $ss_company_phone = SystemSettings::where('name', 'company_phone')->first();
        $ss_company_email = SystemSettings::where('name', 'company_email')->first();
        $ss_company_website = SystemSettings::where('name', 'company_website')->first();
        $ss_company_logo_link = SystemSettings::where('name', 'company_logo_link')->first();
        return view('admin.systemsettings.index', compact(
            'ss_app_title',
            'ss_license_key',
            'ss_license_validity',
            'ss_company_name',
            'ss_company_address',
            'ss_company_phone',
            'ss_company_email',
            'ss_company_website',
            'ss_company_logo_link'
        ));
    }

    public function update(Request $request)
    {
        if (Auth::user()->can('AdminSystemSettings-W')) {
            $settings = SystemSettings::all();
    
            foreach ($settings as $setting) {
                $name = $setting->name;
                $value = $request->input($name . '_value');
                $previousValue = $request->input($name . '_previous_value');
    
                if ($value !== $previousValue) {
                    $setting->update(['value' => $value, 'previous_value' => $previousValue]);
                }
            }
    
            return redirect()->route('systemsettings.index')->with('success', 'System settings updated successfully.');
        } else {
            // Jeżeli użytkownik nie ma wymaganego uprawnienia, możesz zwrócić 403 Forbidden lub przekierować gdzie indziej
            abort(403, 'You do not have sufficient authority to perform this action');
        }
    }

}
