<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateActionTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new action file.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->info($name . 'has been created successfully!');
    }
}