<?php

namespace Ngenius\NgeniusCommon\Formatter;

use NumberFormatter;

class ValueFormatter
{
    /**
     * Uniform API amount response
     *
     * @param $currencyCode
     * @param $amount
     *
     * @return float|int
     */
    public static function formatOrderStatusAmount($currencyCode, $amount)
    {
        if (in_array($currencyCode, ['UGX', 'XOF'])) {
            $amount *= 100;
            $amount = (int)round($amount);
        } elseif (in_array($currencyCode, ['KWD', 'BHD', 'OMR'])) {
            $amount /= 10.000;
            $amount = round($amount, 3);
        }

        return $amount;
    }

    /**
     * Formats currency dependent amount
     *
     * @param $currencyCode
     * @param $amount
     *
     * @return void
     */
    public static function formatCurrencyAmount($currencyCode, &$amount)
    {
        if (in_array($currencyCode, ['UGX', 'XOF'])) {
            $amount /= 100;
        } elseif (in_array($currencyCode, ['KWD', 'BHD', 'OMR'])) {
            $amount *= 10;
        }
    }

    /**
     * Sets amount decimal places for currency
     *
     * @param $currencyCode
     * @param $amount
     *
     * @return void
     */
    public static function formatCurrencyDecimals($currencyCode, &$amount)
    {
        $amount = number_format($amount, self::getCurrencyDecimals($currencyCode));
    }

    /**
     * Safe conversion from float to integer representation
     *
     * @param $floatNumber
     * @param null $currencyCode
     *
     * @return int
     */
    public static function floatToIntRepresentation($currencyCode, $floatNumber)
    {
        $floatNumber = number_format($floatNumber, self::getCurrencyDecimals($currencyCode));

        $floatString = (string)$floatNumber;

        $cleanedString = str_replace([',', '.'], '', $floatString);

        return (int)$cleanedString;
    }

    /**
     * Currency dependent conversion from int to float representation
     *
     * @param string $currencyCode
     * @param int $integer
     *
     * @return float|int
     */
    public static function intToFloatRepresentation($currencyCode, $integer)
    {
        $decimalPlaces = self::getCurrencyDecimals($currencyCode);

        if ($decimalPlaces === 0) {
            return $integer;
        }

        $divisor = pow(10, $decimalPlaces);

        return $integer / $divisor;
    }

    /**
     * Returns number of decimal places for the currency
     *
     * @param $currency
     *
     * @return int
     */
    public static function getCurrencyDecimals($currency)
    {
        $currencyFormatter = new NumberFormatter('en_EN', NumberFormatter::CURRENCY);
        $currencyFormatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency);

        return $currencyFormatter->getAttribute(NumberFormatter::FRACTION_DIGITS);
    }
}
