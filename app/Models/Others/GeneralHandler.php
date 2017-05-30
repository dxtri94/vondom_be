<?php

namespace App\Models\Others;

use App\Models\BaseModel;
use App\Models\Dispute;
use App\Models\Transaction;
use Carbon\Carbon;
use League\Flysystem\Exception;
class GeneralHandler extends BaseModel
{

    public function __construct()
    {

    }

    /**
     * fn create dispute with challenge
     * @param null $challenge
     * @param null $user
     * @return Dispute|null
     */
    public function createDispute($challenge = null, $user = null)
    {
        try {
            // create new dispute
            $dispute = new Dispute(array(
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
                'date' => Carbon::now(),
                'status' => config('constants.DISPUTE_STATUS.NEW')
            ));

            $dispute->save();
            return $dispute;

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * fn create transactions with results
     * @param null $challenge
     * @param null $user
     * @param string $gateway
     * @param integer $amount
     * @param string $type
     * @param string $currency
     * @return Transaction|null
     */
    public function createTransaction($challenge = null, $user = null, $gateway = '', $amount = 0, $type = '', $currency='')
    {
        try {
            // create new Transaction
            $transaction = new Transaction(array(
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
                'gateway_transaction_id' => $gateway,
                'type' => $type,
                'amount' => $amount,
                'currency' => $currency,
                'date' => Carbon::now()
            ));

            $transaction->save();
            return $transaction;

        } catch (Exception $e) {
            return null;
        }
    }
}