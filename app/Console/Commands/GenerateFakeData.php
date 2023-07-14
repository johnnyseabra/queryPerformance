<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Providers\ImportDatabaseServiceProvider;

class GenerateFakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Creating database structure');
        $retTables = \App\Providers\ImportDatabaseServiceProvider::createTables();
        $this->info('Database created');
        
        $this->info('Generating fake data');
        $arrCountData = \App\Providers\FakeDataServiceProvider::generateData();
       
        $this->info('Fake data imported sucessfully!');
        $this->info($arrCountData['socialNetworks'] . ' Social Networks Inserted!');
        $this->info($arrCountData['lists'] . ' Lists Inserted!');
        $this->info($arrCountData['people'] . ' People Inserted!');
        $this->info($arrCountData['peopleBelongs'] . ' Relations List-People Inserted!');
        $this->info($arrCountData['accounts'] . ' Social Networks Accounts Inserted!');
        $this->info($arrCountData['posts'] . ' Posts Inserted!');
        
        $this->info('Creating materialized view');
        $retMV = \App\Providers\ImportDatabaseServiceProvider::createMaterializedView();
        $this->info('Materialized view created');
        
        $this->info('System installed sucessfully');
        
        return 0;
    }
}
