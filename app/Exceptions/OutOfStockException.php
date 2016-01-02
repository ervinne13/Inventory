<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Exceptions;

use Exception;
use Throwable;

/**
 * Description of OutOfStockException
 *
 * @author ervinne
 */
class OutOfStockException extends Exception {

    protected $itemCode;
    protected $stocksRemaining;
    protected $stocksRequired;

    public function __construct($itemCode = null, $stocksRemaining = 0, $stocksRequired = 0, $code = 0, Throwable $previous = null) {
        parent::__construct("There's not enough stocks for item {$itemCode}. Required stocks: {$stocksRequired} while there are only {$stocksRemaining} remaining.", $code, $previous);

        $this->itemCode        = $itemCode;
        $this->stocksRemaining = $stocksRemaining;
        $this->stocksRequired  = $stocksRequired;
    }

    function getItemCode() {
        return $this->itemCode;
    }

    function getStocksRemaining() {
        return $this->stocksRemaining;
    }

    function getStocksRequired() {
        return $this->stocksRequired;
    }

}
