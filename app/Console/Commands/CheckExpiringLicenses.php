<?php

namespace App\Console\Commands;

use App\Models\License;
use App\Mail\LicenseExpiringMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckExpiringLicenses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expiring-licenses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks for licenses expiring in exactly 3 days and sends an email to the user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get licenses expiring in specifically 3 days (ignoring time)
        // Ensure we only look at activated licenses that belong to a user
        $targetDate = now()->addDays(3)->toDateString();

        $licenses = License::whereNotNull('user_id')
            ->whereNotNull('activated_at')
            ->whereDate('expires_at', $targetDate)
            ->get();

        $count = 0;

        foreach ($licenses as $license) {
            if ($license->user) {
                Mail::to($license->user->email)->send(new LicenseExpiringMail($license->user, $license));
                $count++;
            }
        }

        $this->info("Successfully processed expiring licenses. Emailed {$count} users.");
    }
}
