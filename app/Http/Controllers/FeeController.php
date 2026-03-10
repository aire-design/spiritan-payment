<?php

namespace App\Http\Controllers;

use App\Models\AcademicSession;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\Term;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::with(['schoolClass', 'academicSession', 'term'])->latest()->paginate(20);

        return view('fees.index', compact('fees'));
    }

    public function create()
    {
        $classes = SchoolClass::where('is_active', true)->orderBy('name')->get();
        $sessions = AcademicSession::orderByDesc('starts_at')->get();
        $terms = Term::orderByDesc('starts_at')->get();

        return view('fees.create', compact('classes', 'sessions', 'terms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'school_class_id' => ['nullable', 'exists:school_classes,id'],
            'academic_session_id' => ['required', 'exists:academic_sessions,id'],
            'term_id' => ['nullable', 'exists:terms,id'],
            'is_variable' => ['nullable', 'boolean'],
            'late_fee_penalty' => ['nullable', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'is_active' => ['nullable', 'boolean'],
            'item_name' => ['nullable', 'array'],
            'item_name.*' => ['required_with:item_name', 'string', 'max:255'],
            'item_amount' => ['nullable', 'array'],
            'item_amount.*' => ['required_with:item_name', 'numeric', 'min:0'],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ]);

        $data['is_variable'] = (bool) ($data['is_variable'] ?? false);
        $data['is_active'] = (bool) ($data['is_active'] ?? true);

        $totalAmount = 0;
        if (!$data['is_variable'] && !empty($data['item_name'])) {
            foreach ($data['item_amount'] as $itemAmount) {
                $totalAmount += (float)$itemAmount;
            }
            $data['amount'] = $totalAmount;
        } else {
             $data['amount'] = $data['amount'] ?? 0;
        }

        $fee = Fee::create([
            'name' => $data['name'],
            'category' => $data['category'],
            'school_class_id' => $data['school_class_id'],
            'academic_session_id' => $data['academic_session_id'],
            'term_id' => $data['term_id'],
            'amount' => $data['amount'],
            'is_variable' => $data['is_variable'],
            'late_fee_penalty' => $data['late_fee_penalty'] ?? 0,
            'due_date' => $data['due_date'],
            'is_active' => $data['is_active'],
        ]);

        if (!$data['is_variable'] && !empty($data['item_name'])) {
            $items = [];
            foreach ($data['item_name'] as $index => $name) {
                $items[] = [
                    'name' => $name,
                    'amount' => $data['item_amount'][$index],
                ];
            }
            $fee->feeItems()->createMany($items);
        }

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    public function show(Fee $fee)
    {
        $fee->load(['schoolClass', 'academicSession', 'term', 'payments.student']);

        return view('fees.show', compact('fee'));
    }
}
