<?php

namespace App\Enums;

use Illuminate\Support\Number;

/**
 * Currencies a budget amount can be stored in (ISO 4217 codes).
 * Amounts are stored as integers in the currency's minor unit (öre, cents),
 * so this enum is the single place that knows how to convert to and from them.
 */
enum Currency: string
{
    case Sek = 'SEK';

    public static function default(): self
    {
        return self::Sek;
    }

    /**
     * Number of decimals in the minor unit (2 for SEK/EUR, 0 for JPY, 3 for KWD).
     */
    public function decimals(): int
    {
        return match ($this) {
            self::Sek => 2,
        };
    }

    public function locale(): string
    {
        return match ($this) {
            self::Sek => 'sv',
        };
    }

    /**
     * Regex an already normalized input amount ("1250.50") must match.
     */
    public function inputPattern(): string
    {
        return $this->decimals() > 0
            ? '/^\d{1,10}(\.\d{1,'.$this->decimals().'})?$/'
            : '/^\d{1,10}$/';
    }

    /**
     * "1250.5" → 125050. Done with string operations instead of multiplying a float,
     * because floats can't represent most decimals exactly.
     */
    public function toMinorUnits(string $amount): int
    {
        [$whole, $fraction] = array_pad(explode('.', $amount, 2), 2, '');

        return (int) ($whole.str_pad($fraction, $this->decimals(), '0'));
    }

    /**
     * 125050 → "1250,50", the value shown in an edit form's input.
     */
    public function toInputValue(int $minorUnits): string
    {
        return number_format($minorUnits / 10 ** $this->decimals(), $this->decimals(), ',', '');
    }

    /**
     * 125050 → "1 250,50 kr".
     */
    public function format(int $minorUnits): string
    {
        return Number::currency($minorUnits / 10 ** $this->decimals(), in: $this->value, locale: $this->locale());
    }
}
