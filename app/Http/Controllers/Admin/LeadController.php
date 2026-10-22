<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.leads', [
            'leads' => Lead::when($request->status, fn ($q, $s) => $q->where('status', $s))
                ->latest()->paginate(20)->withQueryString(),
            'counts' => Lead::selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status'),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        $lead->update($request->validate(['status' => 'required|in:new,contacted,closed']));

        return back()->with('ok', 'Status diperbarui.');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();

        return back()->with('ok', 'Lead dihapus.');
    }
}