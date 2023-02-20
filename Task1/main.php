<?php

class cardValidator
{
    public function validateCardNumber(string $cardNumber): bool
    {
        $cardNumber = strrev(preg_replace('/[^\d]/','', $cardNumber));

        $sum = 0;
        for ($i = 0, $j = strlen($cardNumber); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $val = $cardNumber[$i];
            } else {
                $val = $cardNumber[$i] * 2;
                if ($val > 9) $val -= 9;
            }
            $sum += $val;
        }
        return (($sum % 10) == 0);
    }


    public function checkIssuingBank(string $cardNumber): string
    {
        $visaPrefix = '/\A(4[0-9]|14)\d+/';
        $mastercardPrefix = '/^5[1-5][0-9]{14}$|^62[0-9]{14}$|^67[0-9]{14}$/';

        $cardNumber = str_replace(' ', '', $cardNumber);

        if (preg_match($visaPrefix, $cardNumber)) {
            return "VISA";
        }
        elseif (preg_match($mastercardPrefix, $cardNumber)) {
            return "MasterCard";
        }
        else {
            return "unknown";
        }
    }
}


$validator = new cardValidator();

if (isset($_POST['submit-card'])) {
    $cardInput = $_POST["card-number"];
    if (!$validator->validateCardNumber($cardInput)) {
        echo $_POST["card-number"] . " - invalid card number";
    } else {
        echo $_POST["card-number"] . " - valid card number," . " Your issuing bank is " . $validator->checkIssuingBank($cardInput);
    }
}