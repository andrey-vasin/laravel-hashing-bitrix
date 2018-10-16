<?php

namespace AndreyVasin\LaravelHashingBitrix;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

/**
 * Class BitrixHasher
 *
 * @package AndreyVasin\LaravelHashingBitrix
 */
class BitrixHasher implements HasherContract
{

    public function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }

    public function make($value, array $options = [])
    {
        $rand = $this->randString();
        $hash = $rand . md5($rand . $value);
        return $hash;
    }

    public function check($value, $hashedValue, array $options = [])
    {
        $strLength = strlen($hashedValue);
        if ($strLength < 32) {
            return false;
        } else if ($strLength === 32) {
            return $hashedValue === md5($value);
        } else {
            $saltLength = $strLength - 32;
            $salt = substr($hashedValue, 0, $saltLength);
            return $hashedValue === $salt . md5($salt . $value);
        }
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    private function randString($length = 6, $alphabet = '1234567890qwertyuiopasdfghjklzxcvbnm')
    {
        $alphabet = str_repeat($alphabet, (int)($length / mb_strlen($alphabet)) + 1);
        return mb_substr(str_shuffle($alphabet), 0, $length);
    }
}
