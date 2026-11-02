<?php

namespace App\Enums;

enum EntryType: string
{
    case Income = 'income';
    case FixedCost = 'fixed_cost';
    case Expense = 'expense';

    public function label(): string
    {
        return match ($this) {
            self::Income => 'Income',
            self::FixedCost => 'Fixed costs',
            self::Expense => 'Expenses',
        };
    }

    /**
     * Only income and fixed costs repeat every month, so only they can be templates.
     *
     * @return list<self>
     */
    public static function recurring(): array
    {
        return [self::Income, self::FixedCost];
    }
}
