<?php

function getAmount($input)
{
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if ($input_count != '0') {
        if ($input_count == '1') {
            return substr($input, 0, -4).'.'.'k';
        } elseif ($input_count == '2') {
            return substr($input, 0, -8).'m';
        } elseif ($input_count == '3') {
            return substr($input, 0, -12).'b';
        } else {
            return;
        }
    } else {
        return $input;
    }
}

function getAmount2(float $input): string
{
    $input = number_format($input, 0, '', '');

    if ($input >= 1e9) {
        return ($input / 1e9).'b';
    } elseif ($input >= 1e6) {
        return ($input / 1e6).'m';
    } elseif ($input >= 1e3) {
        return ($input / 1e3).'k';
    } else {
        return $input;
    }
}
