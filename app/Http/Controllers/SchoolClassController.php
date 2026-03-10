<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name',
            'level' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'School class created successfully.');
    }

    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name,'.$class->id,
            'level' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'School class updated successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        // Simple protection: do not delete if students exist
        if ($class->students()->count() > 0) {
            return redirect()->route('classes.index')
                ->with('error', 'Cannot delete class with assigned students.');
        }

        $class->delete();

        return redirect()->route('classes.index')
            ->with('success', 'School class deleted successfully.');
    }
}
