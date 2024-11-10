<?php

function generateRandomId()
{
    // With this precision (microsecond) ID will looks like '2di2adajgq6h'
    // From PHP 7.4.0 this is needed, otherwise a warning is displayed

    $cleanNumber = preg_replace('/[^0-9]/', '', microtime(false));
    $id = base_convert($cleanNumber, 10, 36);

    // With less precision (second) ID will looks like 'niu7pj'
    // $id = base_convert(time(), 10, 36);

    return $id;
}

/**
 * @param mixed   $in   String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
    $out = '';
    $index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $base = strlen($index);

    if ($pass_key !== null) {
        // Although this function's purpose is to just make the
        // ID short - and not so much secure,
        // with this patch by Simon Franz (http://blog.snaky.org/)
        // you can optionally supply a password to make it harder
        // to calculate the corresponding numeric ID

        for ($n = 0; $n < strlen($index); $n++) {
            $i[] = substr($index, $n, 1);
        }

        $pass_hash = hash('sha256', $pass_key);
        $pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

        for ($n = 0; $n < strlen($index); $n++) {
            $p[] = substr($pass_hash, $n, 1);
        }

        array_multisort($p, SORT_DESC, $i);
        $index = implode($i);
    }

    if ($to_num) {
        // Digital number  <<--  alphabet letter code
        $len = strlen($in) - 1;

        $out = (int) $out;
        for ($t = $len; $t >= 0; $t--) {
            $bcp = pow($base, $len - $t);
            $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
        }

        if (is_numeric($pad_up)) {
            $pad_up--;

            if ($pad_up > 0) {
                $out -= pow($base, $pad_up);
            }
        }
    } else {
        // Digital number  -->>  alphabet letter code
        if (is_numeric($pad_up)) {
            $pad_up--;

            if ($pad_up > 0) {
                $in += pow($base, $pad_up);
            }
        }

        for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
            $bcp = pow($base, $t);
            $a = floor($in / $bcp) % $base;
            $out = $out . substr($index, $a, 1);
            $in = $in - ($a * $bcp);
        }
    }

    return $out;
}
