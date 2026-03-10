<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\User;
use Illuminate\Console\Command;

class LinkParentAccounts extends Command
{
    protected $signature   = 'parents:link {--dry-run : Preview matches without saving}';
    protected $description = 'Link existing students to parent user accounts by matching parent_email → users.email';

    public function handle(): int
    {
        $dryRun  = $this->option('dry-run');
        $updated = 0;
        $skipped = 0;

        Student::whereNull('parent_user_id')
            ->whereNotNull('parent_email')
            ->chunkById(200, function ($students) use ($dryRun, &$updated, &$skipped) {
                foreach ($students as $student) {
                    $user = User::where('email', $student->parent_email)
                        ->where('role', 'parent')
                        ->first();

                    if ($user) {
                        if (! $dryRun) {
                            $student->updateQuietly(['parent_user_id' => $user->id]);
                        }
                        $this->line("  ✓ [{$student->admission_number}] {$student->full_name} → {$user->email}");
                        $updated++;
                    } else {
                        $skipped++;
                    }
                }
            });

        $this->newLine();
        $this->info($dryRun ? '[DRY RUN] No changes were saved.' : 'Done!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Students linked', $updated],
                ['Students skipped (no matching parent account)', $skipped],
            ]
        );

        return self::SUCCESS;
    }
}
