<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DiagnoseStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose storage configuration and file upload issues';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('===========================================');
        $this->info('Laravel Storage Diagnostics');
        $this->info('===========================================');
        $this->newLine();

        // Check 1: Symbolic Link
        $this->info('1. Checking Symbolic Link...');
        $publicStoragePath = public_path('storage');
        $storagePublicPath = storage_path('app/public');
        
        if (is_link($publicStoragePath)) {
            $target = readlink($publicStoragePath);
            $this->line("   ✓ Symbolic link exists");
            $this->line("   → public/storage -> $target");
            
            if (realpath($target) === realpath($storagePublicPath)) {
                $this->line("   ✓ Link points to correct location");
            } else {
                $this->error("   ✗ Link points to wrong location!");
                $this->line("   Expected: $storagePublicPath");
                $this->line("   Actual: $target");
            }
        } else {
            $this->error("   ✗ Symbolic link does NOT exist!");
            $this->line("   Run: php artisan storage:link");
        }
        $this->newLine();

        // Check 2: Directory Permissions
        $this->info('2. Checking Directory Permissions...');
        $directories = [
            'storage/app/public' => storage_path('app/public'),
            'storage/app/public/dispatch_videos' => storage_path('app/public/dispatch_videos'),
            'storage/app/public/delivery-proofs' => storage_path('app/public/delivery-proofs'),
            'public/storage' => public_path('storage'),
        ];

        foreach ($directories as $name => $path) {
            if (file_exists($path)) {
                $perms = substr(sprintf('%o', fileperms($path)), -4);
                $writable = is_writable($path) ? '✓ Writable' : '✗ Not Writable';
                $this->line("   $name: $perms ($writable)");
            } else {
                $this->error("   ✗ $name does NOT exist!");
            }
        }
        $this->newLine();

        // Check 3: Configuration
        $this->info('3. Checking Configuration...');
        $this->line("   APP_URL: " . config('app.url'));
        $this->line("   FILESYSTEM_DISK: " . config('filesystems.default'));
        $this->line("   Public Disk URL: " . config('filesystems.disks.public.url'));
        $this->newLine();

        // Check 4: Upload Directories
        $this->info('4. Checking Upload Directories...');
        $uploadDirs = [
            'dispatch_videos' => storage_path('app/public/dispatch_videos'),
            'delivery-proofs' => storage_path('app/public/delivery-proofs'),
        ];

        foreach ($uploadDirs as $name => $path) {
            if (File::exists($path)) {
                $files = File::files($path);
                $count = count($files);
                $this->line("   ✓ $name: $count file(s)");
                
                if ($count > 0) {
                    $this->line("     Latest: " . basename($files[0]));
                }
            } else {
                $this->error("   ✗ $name directory does NOT exist!");
                $this->line("     Creating directory...");
                File::makeDirectory($path, 0775, true);
                $this->line("     ✓ Directory created");
            }
        }
        $this->newLine();

        // Check 5: Test File Creation
        $this->info('5. Testing File Write...');
        try {
            $testFile = 'test-' . time() . '.txt';
            Storage::disk('public')->put($testFile, 'Test content');
            
            if (Storage::disk('public')->exists($testFile)) {
                $this->line("   ✓ Can write to storage/app/public");
                
                $publicUrl = asset('storage/' . $testFile);
                $this->line("   Public URL: $publicUrl");
                
                // Clean up
                Storage::disk('public')->delete($testFile);
                $this->line("   ✓ Test file cleaned up");
            } else {
                $this->error("   ✗ Failed to write test file");
            }
        } catch (\Exception $e) {
            $this->error("   ✗ Error: " . $e->getMessage());
        }
        $this->newLine();

        // Summary
        $this->info('===========================================');
        $this->info('Diagnosis Complete');
        $this->info('===========================================');
        $this->newLine();

        // Recommendations
        $hasIssues = false;
        
        if (!is_link($publicStoragePath)) {
            $hasIssues = true;
            $this->warn('⚠ Action Required:');
            $this->line('  Run: php artisan storage:link');
            $this->newLine();
        }

        if (!File::exists(storage_path('app/public/dispatch_videos'))) {
            $hasIssues = true;
            $this->warn('⚠ Missing Directory:');
            $this->line('  mkdir -p storage/app/public/dispatch_videos');
            $this->newLine();
        }

        if (!File::exists(storage_path('app/public/delivery-proofs'))) {
            $hasIssues = true;
            $this->warn('⚠ Missing Directory:');
            $this->line('  mkdir -p storage/app/public/delivery-proofs');
            $this->newLine();
        }

        if (!$hasIssues) {
            $this->info('✓ All checks passed! Storage is configured correctly.');
        } else {
            $this->warn('Some issues were found. Please fix them and run this command again.');
        }

        return 0;
    }
}
