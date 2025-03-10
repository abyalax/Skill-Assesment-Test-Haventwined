<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command {
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a new Service Class';

    public function handle() {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service already exists!");
            return;
        }

        File::ensureDirectoryExists(app_path('Services'));

        File::put($path, "<?php

namespace App\Services;

class {$name} {
    public function handle() {
        //
    }
}");

        $this->info("Service {$name} created successfully.");
    }
}
