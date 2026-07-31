<?php

namespace App\Http\Controllers;

use App\Exports\SchoolsExport;
use App\Models\District;
use App\Models\Office;
use App\Models\School;
use App\Models\User;
use App\Notifications\SystemAlertNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class MasterDataController extends Controller
{
    public function index()
    {
        $schools = School::with('district')->latest()->get();
        $districts = District::latest()->get();
        $offices = Office::latest()->get();

        return view('master_data.index', compact('schools', 'districts', 'offices'));
    }

    // ==========================================
    // SCHOOL ENGINE ENDPOINTS
    // ==========================================
    public function storeSchool(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_code' => 'required|string|unique:schools,school_code|max:50',
            'district_id' => 'required|exists:districts,id',
        ]);

        $school = School::create($validated);

        // Notify all administrative users about the new facility registration
        $admins = User::role('Super Admin')->get();
        $payload = [
            'title'      => 'New Facility Added',
            'message'    => "School '{$request->name}' was successfully cataloged.",
            'icon'       => 'fas fa-school text-success',
            'action_url' => route('master-data.index'), // adjust to your routes
        ];
        foreach ($admins as $admin) {
            $admin->notify(new SystemAlertNotification($payload));
        }
        // Load relation for response markup generation
        $school->load('district');

        return response()->json(['success' => true, 'message' => 'School created successfully.', 'data' => $school]);
    }

    public function showSchool($id)
    {
        return response()->json(School::with('district')->findOrFail($id));
    }

    public function updateSchool(Request $request, $id)
    {
        $school = School::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_code' => ['required', 'string', 'max:50', Rule::unique('schools')->ignore($school->id)],
            'district_id' => 'required|exists:districts,id',
        ]);

        $school->update($validated);
        $school->load('district');

        return response()->json(['success' => true, 'message' => 'School updated successfully.', 'data' => $school]);
    }

    public function destroySchool($id)
    {
        School::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'School purged successfully.']);
    }

    public function getSchoolsDataTable(Request $request)
    {
        $query = School::with('district');

        // Server-side global search parsing engine
        if ($request->has('search') && !empty($request->input('search')['value'])) {
            $search = $request->input('search')['value'];
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('school_code', 'LIKE', "%{$search}%")
                ->orWhereHas('district', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
        }

        $totalRecords = School::count();
        $filteredRecords = $query->count();

        // Pagination bounds protection checks
        $data = $query->skip($request->input('start', 0))
            ->take($request->input('length', 10))
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ]);
    }

    // Stream Export Data Directly to Client File Download Buffers
    public function exportExcel()
    {
        return Excel::download(new SchoolsExport, 'schools_master_repository.xlsx');
    }

    public function exportPdf()
    {
        $schools = School::with('district')->get();
        $pdf = Pdf::loadView('exports.schools_pdf', compact('schools'));
        return $pdf->download('schools_master_repository.pdf');
    }

    // ==========================================
    // DISTRICT ENGINE ENDPOINTS
    // ==========================================
    public function storeDistrict(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:districts,name|max:255',
            'code' => 'required|string|unique:districts,code|max:50',
        ]);

        $district = District::create($validated);
        return response()->json(['success' => true, 'message' => 'District logged successfully.', 'data' => $district]);
    }

    public function showDistrict($id)
    {
        return response()->json(District::findOrFail($id));
    }

    public function updateDistrict(Request $request, $id)
    {
        $district = District::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('districts')->ignore($district->id)],
            'code' => ['required', 'string', 'max:50', Rule::unique('districts')->ignore($district->id)],
        ]);

        $district->update($validated);
        return response()->json(['success' => true, 'message' => 'District updated successfully.', 'data' => $district]);
    }

    public function destroyDistrict($id)
    {
        // Add dependency warning validation logic if required natively
        District::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'District purged successfully.']);
    }

    // ==========================================
    // OFFICE ENGINE ENDPOINTS
    // ==========================================
    public function storeOffice(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:offices,name|max:255',
            'building_location' => 'nullable|string|max:255',
        ]);



        $office = Office::create($validated);
        return response()->json(['success' => true, 'message' => 'Office logged successfully.', 'data' => $office]);
    }

    public function showOffice($id)
    {
        return response()->json(Office::findOrFail($id));
    }

    public function updateOffice(Request $request, $id)
    {
        $office = Office::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('offices')->ignore($office->id)],
            'building_location' => 'nullable|string|max:255',
        ]);

        $office->update($validated);
        return response()->json(['success' => true, 'message' => 'Office metadata altered successfully.', 'data' => $office]);
    }

    public function destroyOffice($id)
    {
        Office::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Office record removed successfully.']);
    }
}
