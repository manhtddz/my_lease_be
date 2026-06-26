<?php

namespace App\Console\Commands;

use App\Services\Api\DebtService;
use Illuminate\Console\Command;

class ExecuteOverdueInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:execute-overdue-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flag invoices overdue for more than a month as NOT_PAID_OVERDUE and create matching debts';

    /**
     * Execute the console command.
     */
    public function handle(DebtService $debtService): int
    {
        $this->info('Processing overdue invoices...');

        $result = $debtService->executeOverdueInvoices();

        $this->info(sprintf(
            'Done. Matched: %d, converted: %d, skipped: %d.',
            $result['total'],
            $result['processed'],
            $result['skipped'],
        ));

        return self::SUCCESS;
    }
}
