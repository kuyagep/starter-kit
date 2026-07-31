<?php

namespace App\Http\Controllers\DTS;

use App\Http\Controllers\Controller;
use Dom\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function receive(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $user = auth()->user();

        // 1. Update primary document tracker status
        $document->update([
            'status' => 'Received'
        ]);

        // 2. Generate tracking milestone event entry
        $document->trails()->create([
            'action_by_user_id' => $user->id,
            'office_id' => $user->office_id,
            'action' => 'Received',
            'remarks' => $request->input('remarks', 'Document officially received at desk.')
        ]);

        return redirect()->back()->with('success', 'Document status updated and tracked successfully.');
    }
}
