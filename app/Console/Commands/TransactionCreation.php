<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TransactionCreation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:transaction {className} {symbol} {--deliverable} {--cancelable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Transaction class and add it to the WarehouseTransactionsFactory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $className      = $this->argument('className');
        $deliverable    = $this->option('deliverable');
        $cancelable     = $this->option('cancelable');
        $symbol         = $this->argument('symbol');

        $steps = [
            'Creating Transaction Class' => function() use ($className, $deliverable, $cancelable, $symbol) {
                $this->newLine();
                $this->createTransactionClass($className, $deliverable, $cancelable, $symbol);
            },
            'Adding to Transaction Types' => function() use ($className) {
                $this->newLine();
                $this->addToTransactionTypes($className);
            },
            'Adding to Warehouse Transactions Factory' => function() use ($className, $symbol) {
                $this->newLine();
                $this->addToWarehouseTransactionsFactory($className, $symbol);
            },
            'Adding to Transaction Header Model' => function() use ($className) {
                $this->newLine();
                $this->addToTransactionHeaderModel($className);
            },
        ];

        $this->withProgressBar($steps, function ($step) {
            $step();
            sleep(1);  // Just for demonstration
           
        });
        $this->newLine();
        $this->info('Done!');
    }

    /**
     * Create Transaction Class
     *
     * @param string $className
     * @param bool $deliverable
     * @param bool $cancelable
     */
    private function createTransactionClass(string $className, bool $deliverable, bool $cancelable, $symbol): void
    {
        $this->info('checking if transaction class already exists ...');
        $this->separateBetweenLines();
        if (file_exists(app_path('Classes/' . $className . '.php'))) {
            $this->error('Transaction class already exists');
        } else {
            $this->info('Transaction does not exist in app/Classes');
            $this->info('Creating Transaction: ' . $className);
            $classContent = $this->getTransactionClassContent($className, $deliverable, $cancelable, $symbol);
            $path = app_path('Classes/' . $className . '.php');
            file_put_contents($path, $classContent);
        }
    }

    private function getTransactionClassContent(string $className, bool $deliverable, bool $cancelable, $symbol): string
    {
        $deliverableInterface = $deliverable == true ? 'IDeliverable' : '';
        $cancelableInterface = $cancelable ? 'ICancelable' : '';

        $implements = $deliverableInterface || $cancelableInterface ? 'implements ' : '';

        $comma = $deliverableInterface && $cancelableInterface ? ', ' : '';

        $interfaces = $implements . $deliverableInterface . $comma . $cancelableInterface;

        $stub = $this->getStub('TransactionClass');
        $stub = str_replace('$className', $className, $stub);
        $stub = str_replace('$implementation', $interfaces, $stub);

        $deliverMethod = '';
        if ($deliverable) {
            $deliverMethod = $this->getStub('DeliverMethod');
        }
        $stub = str_replace('// deliver method', $deliverMethod, $stub);

        $cancelMethod = '';
        if ($cancelable) {
            $cancelMethod = $this->getStub('CancelMethod');
        }
        $stub = str_replace('// cancel method', $cancelMethod, $stub);

        return $stub;
    }

    private function addToWarehouseTransactionsFactory(string $className, $symbol): void
    {

        $this->info('Checking if Transaction already exists in WarehouseTransactionsFactory ...');
        $this->separateBetweenLines();
        $factoryPath = app_path('Classes/WarehouseTransactionsFactory.php');
        $factoryContent = file_get_contents($factoryPath);

        // check if the class already exists in the factory
        if (strpos($factoryContent, $className) !== false) {
            $this->error('Transaction already exists in WarehouseTransactionsFactory');
            return;
        }
        // Add the class to the transactions array
        $newLine = "\t'$symbol' => new $className(),";
        $factoryContent = str_replace('// new transactions', "$newLine\n\t\t// new transactions", $factoryContent);

        file_put_contents($factoryPath, $factoryContent);
        $this->info('Added to Transaction Factory.');
    }
    private function getStub(string $stubName): string
    {
        return file_get_contents(base_path("stubs/$stubName.stub"));
    }

    private function addToTransactionHeaderModel(string $className): void
    {
        $this->info('Checking if Transaction Header Model already exists ...');
        $this->separateBetweenLines();

        if (file_exists(app_path('Models/Transactions/' . $className . '.php'))) {
            $this->error('Transaction Header Model already exists');
            return;
        }
        $this->info('Creating Transaction Header Model: ' . $className);
        $stub = $this->getStub('TransactionHeader');
        $stub = str_replace('$className', $className, $stub);
        $path = app_path('Models/Transactions');
        $path = $path . '/' . $className . '.php';
        file_put_contents($path, $stub);
    }

    private function addToTransactionTypes(string $className): void
    {
        $this->info('Checking if transaction already exists in database ...');
        $this->separateBetweenLines();
        $exists = \App\Models\TransactionType::where('name', $className)->first();
        if ($exists) {
            $this->error('Transaction already exists in database with number : ' . $exists->number);
            return;
        }

        $this->info('Transaction does not exist in database');

        $this->info('Adding to Transaction Types table ...');
        $lastRecord = \App\Models\TransactionType::orderBy('id', 'desc')->first();
        $number = $lastRecord ? $lastRecord->number + 1 : 1;

        \App\Models\TransactionType::create([
            'name' => $className,
            'number' => $number,
        ]);
        $this->info('Added to Transaction Types table with number : ' . $number);
    }

    private function separateBetweenLines()
    {
        sleep(1);
        $this->info('----------------------------------------');
        sleep(1);
        $this->info('--------');
        sleep(1);
    }
}
