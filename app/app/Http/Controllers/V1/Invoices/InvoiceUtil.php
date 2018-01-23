<?php

namespace App\Http\Controllers\V1\Invoices;


class InvoiceUtil
{
    /**
     * @param int $length
     * @return string
     */
    public static function generateReference(int $length): string
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return strtoupper($token);
    }
}