<?php
namespace App\Exceptions;

class FraudException extends \Exception {
    const   IP_FACTOR = 'IP_FACTOR',
            FP_FACTOR = 'FP_FACTOR';
    const   STATE_PREVENT = 'STATE_PREVENT',
            STATE_MONITOR = 'STATE_MONITOR';

    /** @var null|string $fraud_factor */
    protected $fraud_factor;
    /** @var null|string $fraud_state */
    protected $fraud_state;

    public function __construct($message = "Fraudulent vote predicted.", $code = 403, \Exception $previous = null, $factor = null, $state = null)
    {
        $this->fraud_factor = $factor;
        $this->fraud_state = $state;
        parent::__construct($message, $code, $previous);
    }

}