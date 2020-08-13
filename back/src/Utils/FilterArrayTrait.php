<?php

namespace App\Utils;

Trait FilterArrayTrait
{
    public function filterFinancialMovementsByWallet(array $financialMovements, string $walletId) : array
    {
        $output = [];
        foreach($financialMovements as $financialMovement)
        {
            if($financialMovement['walletId'] === $walletId)
                $output[] = $financialMovement;
        }
        return $output;
    }
}