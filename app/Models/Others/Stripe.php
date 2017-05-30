<?php

namespace App\Models\Others;

use App\Models\BaseModel;
use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Transfer;

class Stripe extends BaseModel
{
    /**
     * StripePayment constructor.
     */
    public static function setKeyStripe()
    {
        $mode = env('STRIPE_MODE', 'live');
        if ($mode === 'test') {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        } else {
            \Stripe\Stripe::setApiKey(env('STRIPE_LIVE_SECRET'));
        }
    }

    public static function changeAmount($aud)
    {
        $cent = $aud * 100;
        return $cent;
    }

    /**
     * Charge with transfer group
     *
     * @param array $user
     * @param float $amount
     * @param string $description
     * @return bool|Charge
     */
    public static function chargeWithTransferGroup($user = array(), $amount = 0.0, $description = '', $product = null)
    {
        try {
            if (empty($user->bank)) {
                return false;
            }

            self::setKeyStripe();

            $charge = Charge::create([
                "amount" => self::changeAmount($amount),
                "currency" => env('STRIPE_CURRENCY', "AUD"),
                "description" => $description,
                "source" => [
                    'name' => $user->bank->card_name,
                    'exp_month' => $user->bank->exp_month,
                    'exp_year' => $user->bank->exp_year,
                    'number' => $user->bank->card_number,
                    'cvc' => $user->bank->cvc
                ],
                "transfer_group" => "PRODUCT#" . $product->id,
            ]);

            if (!empty($charge) && $charge->id) {
                //Log::info('Charged', ['charge' => $charge->id]);
            }
            return $charge;
        } catch (\Exception $e) {
            Log::error('Charge with group', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Transfer with group
     *
     * @param array $product
     * @param int $amount
     * @param string $stripe_connect_account_id
     * @return bool|Transfer
     */
    public static function transferWithGroup($product = array(), $amount = 0, $stripe_connect_account_id = 'default_for_currency')
    {
        try {
            self::setKeyStripe();

            $transfer = Transfer::create(array(
                "amount" => self::changeAmount($amount),
                "currency" => env('STRIPE_CURRENCY', "AUD"),
                "destination" => $stripe_connect_account_id,
                "transfer_group" => "PRODUCT#" . $product->id,
            ));

            //Log::info('Transferred', ['transfer' => $transfer]);
            return $transfer;
        } catch (\Exception $e) {
            Log::error('Transferred error', ['error' => $e->getMessage()]);
            return false;
        }
    }
}