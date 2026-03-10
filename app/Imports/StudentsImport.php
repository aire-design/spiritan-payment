<?php

namespace App\Imports;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class StudentsImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public array $importedRows  = [];
    public array $skippedRows   = [];
    public array $errors        = [];

    /** Cached class name → ID map, built once per import. */
    private array $classMap = [];

    public function __construct()
    {
        $this->classMap = SchoolClass::pluck('id', 'name')->all();
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $index => $row) {
            $rowNum = $index + 2; // +2 because row 1 is the heading

            // Required field guard
            $admissionNumber = trim((string) ($row['admission_number'] ?? ''));
            $firstName       = trim((string) ($row['first_name'] ?? ''));
            $lastName        = trim((string) ($row['last_name'] ?? ''));
            $className       = trim((string) ($row['class'] ?? ''));
            $parentName      = trim((string) ($row['parent_name'] ?? ''));
            $parentPhone     = trim((string) ($row['parent_phone'] ?? ''));

            if (! $admissionNumber || ! $firstName || ! $lastName || ! $className) {
                $this->skippedRows[] = "Row {$rowNum}: missing required field (admission_number, first_name, last_name, or class).";
                continue;
            }

            // Resolve class ID
            $classId = $this->classMap[$className] ?? null;
            if (! $classId) {
                $this->skippedRows[] = "Row {$rowNum}: class '{$className}' not found. Create the class first.";
                continue;
            }

            $parentEmail = strtolower(trim((string) ($row['parent_email'] ?? ''))) ?: null;

            // Resolve parent user FK
            $parentUserId = null;
            if ($parentEmail) {
                $parentUserId = User::where('email', $parentEmail)
                    ->where('role', 'parent')
                    ->value('id');
            }

            try {
                DB::transaction(function () use (
                    $admissionNumber, $firstName, $lastName, $row,
                    $classId, $parentName, $parentPhone, $parentEmail, $parentUserId, $rowNum
                ) {
                    Student::updateOrCreate(
                        ['admission_number' => $admissionNumber],
                        [
                            'first_name'           => $firstName,
                            'last_name'            => $lastName,
                            'other_name'           => trim((string) ($row['other_name'] ?? '')) ?: null,
                            'school_class_id'      => $classId,
                            'parent_name'          => $parentName ?: 'N/A',
                            'parent_phone'         => $parentPhone ?: 'N/A',
                            'parent_email'         => $parentEmail,
                            'parent_user_id'       => $parentUserId,
                            'status'               => in_array(strtolower($row['status'] ?? 'active'), ['active','inactive','graduated'])
                                                        ? strtolower($row['status'])
                                                        : 'active',
                        ]
                    );
                    $this->importedRows[] = $admissionNumber;
                });
            } catch (\Throwable $e) {
                $this->skippedRows[] = "Row {$rowNum} ({$admissionNumber}): " . $e->getMessage();
            }
        }
    }
}
