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
        $modelName      = $className . 'Model';
        $deliverable    = $this->option('deliverable');
        $cancelable     = $this->option('cancelable');
        $symbol         = $this->argument('symbol');

        $steps = [
            'Creating Transaction Class' => function() use ($className, $deliverable, $cancelable,$modelName) {
                $this->newLine();
                $this->createTransactionClass($className, $deliverable, $cancelable, $modelName);
            },
            'Adding to Transaction Types' => function() use ($symbol) {
                $this->newLine();
                $this->addToTransactionTypes($symbol);
            },
            'Adding to Warehouse Transactions Factory' => function() use ($className, $symbol) {
                $this->newLine();
                $this->addToWarehouseTransactionsFactory($className, $symbol);
            },
            'Adding to Transaction Header Model' => function() use ($className, $modelName) {
                $this->newLine();
                $this->addToTransactionHeaderModel($className, $modelName);
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
    private function createTransactionClass(string $className, bool $deliverable, bool $cancelable, $modelName): void
    {
        $this->line('checking if transaction class already exists ...');
        $this->separateBetweenLines();
        if (file_exists(app_path('Classes/' . $className . '.php'))) {
            $this->error('Transaction class already exists');
        } else {
            $this->line('Transaction does not exist in app/Classes');
            $this->info('Creating Transaction: ' . $className);
            $classContent = $this->getTransactionClassContent($className, $modelName, $deliverable, $cancelable);
            $path = app_path('Classes/' . $className . '.php');
            file_put_contents($path, $classContent);
        }
    }

    private function getTransactionClassContent(string $className, string $modelName, bool $deliverable, bool $cancelable): string
    {
        $deliverableInterface = $deliverable == true ? 'IDeliverable' : '';
        $cancelableInterface = $cancelable ? 'ICancelable' : '';

        $implements = $deliverableInterface || $cancelableInterface ? 'implements ' : '';

        $comma = $deliverableInterface && $cancelableInterface ? ', ' : '';

        $interfaces = $implements . $deliverableInterface . $comma . $cancelableInterface;

        $stub = $this->getStub('TransactionClass');
        $stub = str_replace('$className', $className, $stub);
        $stub = str_replace('$modelName', $modelName, $stub);
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

        $this->line('Checking if Transaction already exists in WarehouseTransactionsFactory ...');
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

    private function addToTransactionHeaderModel(string $className, $modelName): void
    {

        $this->line('Checking if Transaction Header Model already exists ...');
        $this->separateBetweenLines();

        if (file_exists(app_path('Models/Transactions/' . $modelName . '.php'))) {
            $this->error('Transaction Header Model already exists');
            return;
        }
        $this->line('Creating Transaction Header Model: ' . $modelName);
        $stub = $this->getStub('TransactionHeader');
        $stub = str_replace('$className', $className, $stub);
        $stub = str_replace('$modelName', $modelName, $stub);
        $number = $this->getNumber();
        $stub = str_replace('$number', $number, $stub);
        $path = app_path('Models/Transactions');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $path = $path . '/' . $modelName . '.php';
        file_put_contents($path, $stub);
        $this->info('Added to Transaction Header Model.');
    }

    private function addToTransactionTypes(string $symbol): void
    {
        $this->line('Checking if transaction already exists in database ...');
        $this->separateBetweenLines();
        $exists = \App\Models\TransactionType::where('name', $symbol)->first();
        if ($exists) {
            $this->error('Transaction already exists in database with number : ' . $exists->number);
            return;
        }

        $this->line('Transaction does not exist in database');
        $this->line('Adding to Transaction Types table ...');
        $number = $this->getNumber();

        \App\Models\TransactionType::create([
            'name' => $symbol,
            'number' => $number,
        ]);
        $this->info('Added to Transaction Types table with number : ' . $number);
    }

    private function getNumber(){
        $lastRecord = \App\Models\TransactionType::orderBy('id', 'desc')->first();
        return $lastRecord ? $lastRecord->number + 1 : 1;
    }

    private function separateBetweenLines()
    {
        sleep(1);
        $this->line('----------------------------------------');
        sleep(1);
        $this->line('--------');
        sleep(1);
    }
}
