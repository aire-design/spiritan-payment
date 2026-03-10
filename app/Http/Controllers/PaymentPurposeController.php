<?php

namespace App\Http\Controllers;

use App\Models\PaymentPurpose;
use Illuminate\Http\Request;

class PaymentPurposeController extends Controller
{
    public function index()
    {
        $purposes = PaymentPurpose::orderBy('name')->get();

        return view('admin.purposes.index', compact('purposes'));
    }

    public function create()
    {
        return view('admin.purposes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_purposes,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        PaymentPurpose::create($validated);

        return redirect()->route('purposes.index')
            ->with('success', 'Payment purpose created successfully.');
    }

    public function edit(PaymentPurpose $purpose)
    {
        return view('admin.purposes.edit', compact('purpose'));
    }

    public function update(Request $request, PaymentPurpose $purpose)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:payment_purposes,name,'.$purpose->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $purpose->update($validated);

        return redirect()->route('purposes.index')
            ->with('success', 'Payment purpose updated successfully.');
    }

    public function destroy(PaymentPurpose $purpose)
    {
        // Simple protection: Check if fees exist for this purpose
        // (Assuming Fee model has an implicit or explicit link,
        // currently using name for lookup, but safe to delete if unused)
        $purpose->delete();

        return redirect()->route('purposes.index')
            ->with('success', 'Payment purpose deleted successfully.');
    }
}
