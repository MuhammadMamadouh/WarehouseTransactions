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
    protected $signature = 'create:transaction {className} {symbol} {--deliverable=false} {--cancelable=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Transaction';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $className = $this->argument('className');
        $deliverable = filter_var($this->option('deliverable'), FILTER_VALIDATE_BOOLEAN);
        $cancelable = filter_var($this->option('cancelable'), FILTER_VALIDATE_BOOLEAN);
        $symbol = $this->argument('symbol');

        $this->createTransaction($className, $deliverable, $cancelable, $symbol);
    }

    /**
     * Create new Transaction
     *
     * @param string $className
     * @param bool $deliverable
     * @param bool $cancelable
     */
    private function createTransaction(string $className, bool $deliverable, bool $cancelable, string $symbol): void
    {
        $this->info('Creating Transaction: ' . $className);

        $this->createTransactionClass($className, $deliverable, $cancelable, $symbol);
        // $this->createTransactionInterface($className, $deliverable, $cancelable);
        // $this->createTransactionFactory($className);
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
        $classContent = $this->getTransactionClassContent($className, $deliverable, $cancelable, $symbol);
        $this->createClassFile($className, $classContent);
    }

    private function getTransactionClassContent(string $className, bool $deliverable, bool $cancelable, $symbol): string
    {
        $deliverableInterface = $deliverable == true ? 'IDeliverable' : '';
        $cancelableInterface = $cancelable ? 'ICancelable' : '';
        // dd($deliverableInterface, $cancelableInterface);

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

        $this->info('Transaction class created successfully.');

        $this->addToWarehouseTransactionsFactory($className, $symbol);


        return $stub;
    }

    private function addToWarehouseTransactionsFactory(string $className, $symbol): void
    {
        $factoryPath = app_path('Classes/WarehouseTransactionsFactory.php');
        $factoryContent = file_get_contents($factoryPath);

        // Add the class to the transactions array
        $newLine = "\t'$symbol' => new $className(),";
        $factoryContent = str_replace('// new transactions', "$newLine\n\t\t// new transactions", $factoryContent);

        file_put_contents($factoryPath, $factoryContent);
    }
    private function getStub(string $stubName): string
    {
        return file_get_contents(base_path("stubs/$stubName.stub"));
    }

    private function createClassFile(string $className, string $classContent): void
    {
        $path = app_path('Classes/' . $className . '.php');
        file_put_contents($path, $classContent);
    }


}
