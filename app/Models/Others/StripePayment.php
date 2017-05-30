<?php

namespace App\Models\Others;

use App\Models\BaseModel;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Stripe;

class StripePayment extends BaseModel
{
    public $stripe;
    public $currency;
    public $tax_percent;

    /**
     * StripePayment constructor.
     */
    public function __construct()
    {
        $mode = env('STRIPE_MODE', 'live');
        if ($mode === 'test') {
            $this->stripe = new Stripe(env('STRIPE_SECRET'), env('STRIPE_API_VERSION'));
        } else {
            $this->stripe = new Stripe(env('STRIPE_LIVE_SECRET'), env('STRIPE_API_VERSION'));
        }
        $this->currency = env('STRIPE_CURRENCY', "AUD");
        $this->tax_percent = env('STRIPE_TAX', null);
    }

    /**
     * fn transfer to connected account
     * @param array $product
     * @param int $amount
     * @param int $feePercentage
     * @param string $stripeAccountID
     * @return bool
     */
    public function transfer($product = array(), $amount = 0, $feePercentage = 0, $stripeAccountID = 'default_for_currency')
    {
        try {
            $stripe = $this->stripe;

            $params = array(
                'amount' => $amount,
                'currency' => env('STRIPE_CURRENCY', "AUD"),
                'destination' => $stripeAccountID,
                'description' => 'Transfer to buyer of listing #' . $product->id
            );

            if ($stripeAccountID !== 'default_for_currency') {
                $params['application_fee'] = $amount * $feePercentage;
            }

            $transfer = $stripe->transfers()->create($params);

            if (!$transfer) {
                return false;
            }

            return $transfer;
        } catch (StripeException $e) {
            return false;
        }
    }

    /**
     * charge by amount
     * @param array $user
     * @param float $amount
     * @param string $description
     * @param array $options
     * @return bool
     */
    public function charge($user = array(), $amount = 0.0, $description = '', $options = array())
    {
        try {

            $stripe = $this->stripe;

            // set params
            $params = array(
                'amount' => $amount,
                'currency' => $this->currency,
                'description' => $description,
                'receipt_email' => $user->email
            );

            // card is customer
            if (is_array($options) AND isset($options['id'])) {
                $params['customer'] = $options['id'];
            } else {
                // optional, add source if customer is empty
                // cards token
                if (is_string($options)) {
                    $params['source'] = $options;
                }

                // card is object
                if (is_array($options)) {
                    $params['source'] = array(
                        'object' => 'card',
                        'name' => $options['holder_name'],
                        'exp_month' => $options['exp_month'],
                        'exp_year' => $options['exp_year'],
                        'number' => $options['card_number'],
                        'cvc' => $options['cvc']
                    );
                } else {
                    return false;
                }
            }

            // create charge
            $charge = $stripe->charges()->create($params);
            if (!$charge) {
                return false;
            }

            return $charge;
        } catch (StripeException $e) {
            return false;
        }
    }

    /**
     * fn refund an charge payment stripe
     * @param array $charge
     * @return bool
     */
    public function refund($charge = array())
    {
        try {
            $stripe = $this->stripe;

            if (!$charge) {
                return false;
            }

            if (is_string($charge)) {
                $chargeId = $charge;
            } else {
                $chargeId = $charge['id'];
            }

            $refund = $stripe->refunds()->create($chargeId);

            if (!$refund) {
                return false;
            }

            return $refund;
        } catch (StripeException $e) {
            return false;
        }
    }

    /**
     * subscribe a plan - billing cycle
     * @param array $plan
     * @param array $options
     * @return Payment|bool
     */
    public function subscribe($plan = array(), $options = array())
    {
        try {
            $stripe = $this->stripe;

            if (empty($customer) OR empty($customer)) {
                return false;
            }

            // find stripe plan
            $stripePlan = $stripe->plans()->find($plan->stripe_plan);
            if (!$stripePlan) {
                return false;
            }

            $params = array(
                'plan' => $stripePlan['id'],
                'application_fee_percent' => 0.0,
                'tax_percent' => $this->tax_percent
            );

            // card is customer
            if (is_array($options) AND isset($options['id'])) {
                $params['customer'] = $options['id'];
            } else {
                // optional, add source if customer is empty
                // card is token
                if (is_string($options)) {
                    $params['source'] = $options;
                }

                // card is object
                if (is_array($options)) {
                    $params['source'] = array(
                        'object' => 'card',
                        'name' => $options['holder_name'],
                        'exp_month' => $options['exp_month'],
                        'exp_year' => $options['exp_year'],
                        'number' => $options['card_number'],
                        'cvc' => $options['cvc']
                    );
                } else {
                    return false;
                }
            }

            // card is customer
            if (is_array($options) AND isset($options['id'])) {
                $params['customer'] = $options['id'];
            } else {
                // optional, add source if customer is empty
                // card is token
                if (is_string($options)) {
                    $params['source'] = $options;
                }

                // card is object
                if (is_array($options)) {
                    $params['source'] = array(
                        'object' => 'card',
                        'name' => $options['holder_name'],
                        'exp_month' => $options['exp_month'],
                        'exp_year' => $options['exp_year'],
                        'number' => $options['card_number'],
                        'cvc' => $options['cvc']
                    );
                } else {
                    return false;
                }
            }

            $subscription = $stripe->subscriptions()->create($customer['id'], $params);

            if (!$subscription) {
                return false;
            }

            return $subscription;
        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * fn cancel a subscription
     * @param array $customer
     * @param array $subscription
     * @return array|bool
     */
    public function unsubscribe($customer = array(), $subscription = array(), $period_end = false)
    {
        try {
            $stripe = $this->stripe;

            if (empty($customer) OR empty($subscription)) {
                return false;
            }

            $subscription = $stripe->subscriptions()->cancel($customer['id'], $subscription['id'], $period_end);
            if (!$subscription) {
                return false;
            }

            return $subscription;

        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * fn change subscription with new plan
     * @param array $customer
     * @param array $subscription
     * @param array $plan
     * @return array|bool
     */
    public function changeSubscription($customer = array(), $subscription = array(), $plan = array())
    {
        try {
            $stripe = $this->stripe;

            if (empty($customer) OR empty($subscription)) {
                return false;
            }

            $subscription = $stripe->subscriptions()->update($customer['id'], $subscription['id'], array(
                'plan' => $plan->stripe_plan
            ));
            if (!$subscription) {
                return false;
            }

            return $subscription;

        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * get subscription
     * @param string $customerId
     * @param string $subscriptionId
     * @return bool
     */
    public function getSubscription($customerId = '', $subscriptionId = '')
    {
        try {
            $stripe = $this->stripe;

            $subscription = $stripe->subscriptions()->find($customerId, $subscriptionId);

            if (!$subscription) {
                return false;
            }

            return $subscription;

        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * fn find customer
     * @param array $user
     * @param array $card
     * @return bool
     */
    public function customer($user = array(), $card = array())
    {
        try {
            $stripe = $this->stripe;

            if ($user->stripe_customer) {
                try {
                    $customer = $stripe->customers()->find($user->stripe_customer);
                    return $customer;
                } catch (StripeException $e) {
                    // does not anything to pass
                }
            }

            $params = array(
                'email' => $user->email
            );

            if (is_string($card)) {
                $params['source'] = $card;
            } else if (is_array($card)) {
                $params['source'] = array(
                    'name' => $card['holder_name'],
                    'exp_month' => $card['expire_month'],
                    'exp_year' => $card['expire_year'],
                    'number' => $card['number'],
                    'object' => 'card',
                    'cvc' => $card['cvc']
                );
            }

            $customer = $stripe->customers()->create($params);
            if (!$customer) {
                return false;
            }

            $user->update(array(
                'stripe_customer' => $customer['id']
            ));

            return $customer;
        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * fn get all plans by stripe
     * @return bool
     */
    public function plans()
    {
        try {
            $stripe = $this->stripe;

            $plans = $stripe->plans()->all();
            return $plans['data'];

        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }

    /**
     * fn find plan
     * @param array $subPlan
     * @return bool
     */
    public function plan($subPlan = array())
    {
        try {
            $stripe = $this->stripe;

            try {
                $plan = $stripe->plans()->find($subPlan->stripe_plan);
                return $plan;
            } catch (StripeException $e) {
                // does not anything
            }

            $plan = $stripe->plans()->create(array(
                'id' => str_replace(' ', '_', $subPlan->title),
                'name' => $subPlan->title,
                'amount' => abs($subPlan->cost),
                'currency' => $this->currency,
                'interval_count' => 1
            ));

            if (!$plan) {
                return false;
            }

            $subPlan->update(array(
                'stripe_plan' => $plan['id']
            ));

        } catch (StripeException $e) {
            dd($e->getMessage());
            return false;
        }
    }
}