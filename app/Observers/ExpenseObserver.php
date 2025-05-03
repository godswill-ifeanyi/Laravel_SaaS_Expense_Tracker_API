<?php

namespace App\Observers;

use App\Models\Expense;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ExpenseObserver
{

    /**
     * Handle the Expense "updated" event.
     */
    public function updated(Expense $expense): void
    {
        $oldValues = $expense->getOriginal();

        AuditLog::create([
            'user_id' => Auth::id(),
            'company_id' => $expense->company_id,
            'action' => 'update',
            'changes' => [
                'before' => $oldValues,
                'after' => $expense->toArray()
            ],
        ]);
    }

    /**
     * Handle the Expense "deleted" event.
     */
    public function deleted(Expense $expense): void
    {
        $oldValues = $expense->getOriginal();
        
        AuditLog::create([
            'user_id' => Auth::id(),
            'company_id' => $expense->company_id,
            'action' => 'delete',
            'changes' => [
                'before' => $oldValues,
                'after' => null
            ],
        ]);
    }
}
