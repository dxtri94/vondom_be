<?php

namespace App\Models\Others;

use App\Models\BaseModel;

class GenerateNumber extends BaseModel
{
    private $numbers = array();

    public function __construct()
    {

    }

    /**
     * fn generate the win number in list
     * @param array $numbers
     * @return bool|mixed
     */
    public function generateWinNumber($numbers = array())
    {
        // Shuffle an array
        shuffle($numbers);

        // If array has only one number.
        if (count($numbers) === 0) {
            return false;
        }

        // Random number secure, start from 0 to length of list
        // Generates cryptographically secure pseudo-random integers (position)
        $positionNumber = random_int(0, count($numbers) - 1);

        // Retrieve random number
        $result = $numbers[$positionNumber];

        return $result;
    }

    /**
     * fn object win number in list
     * @param int $winNumber
     * @param array $ticketNumbers
     * @return bool|mixed
     */
    public function findTicketNumber($winNumber = -1, $ticketNumbers = array()){
        foreach ($ticketNumbers as $index => $ticketNumber) {
            if ((int)$ticketNumber->number === (int)$winNumber) {
                return $ticketNumber;
            }
        }

        return false;
    }
}