<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patron;
use App\Models\Librarian;
use App\Models\SystemSetting;
use App\Models\Borrow;

class AdminController extends Controller
{
    // 1. DASHBOARD & SETTINGS
    public function index()
    {
        $patrons = Patron::all();
        $librarians = Librarian::all();
        
        // Fetch settings as an associative array for easy access
        $settings = SystemSetting::all()->pluck('setting_value', 'setting_key');
        
        return view('admin.dashboard', compact('patrons', 'librarians', 'settings'));
    }

    // 2. UPDATE SYSTEM PARAMETERS (Business Rule: Admin updates parameters)
    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SystemSetting::where('setting_key', $key)->update(['setting_value' => $value]);
        }
        return redirect()->back()->with('success', 'System parameters updated successfully.');
    }

    // 3. MANAGE PATRONS (Business Rule: Admin manages accounts)
    public function storePatron(Request $request)
    {
        Patron::create($request->all());
        return redirect()->back()->with('success', 'Patron account created.');
    }

    public function deletePatron($id)
    {
        Patron::destroy($id);
        return redirect()->back()->with('success', 'Patron account deleted.');
    }

    // 4. MANAGE LIBRARIANS
    public function storeLibrarian(Request $request)
    {
        Librarian::create($request->all());
        return redirect()->back()->with('success', 'Librarian account created.');
    }

    public function deleteLibrarian($id)
    {
        Librarian::destroy($id);
        return redirect()->back()->with('success', 'Librarian account deleted.');
    }

    // 5. DELETE INVALID RECORDS (Business Rule: Delete duplicate/invalid records)
    public function cleanupRecords()
    {
        // Example: Delete 'pending' requests older than 30 days (stale data)
        $deleted = Borrow::where('status', 'pending')
                         ->where('borrow_date', '<', now()->subDays(30))
                         ->delete();
                         
        return redirect()->back()->with('success', "Cleanup complete. $deleted stale records removed.");
    }
}