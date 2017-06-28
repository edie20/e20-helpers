<?php

namespace CIS\Helpers;

class NumberHelper {

    static public function number_to_size($num, $precision = 1)
    {
        // Strip any formatting
        $num = 0 + str_replace(',','',$num);

        // Can't work with non-numbers...
        if (! is_numeric($num))
        {
            return false;
        }

        if ($num >= 1000000000000)
        {
            $num = round($num / 1099511627776, $precision);
            $unit = 'TB';
        }
        elseif ($num >= 1000000000)
        {
            $num = round($num / 1073741824, $precision);
            $unit = 'GB';
        }
        elseif ($num >= 1000000)
        {
            $num = round($num / 1048576, $precision);
            $unit = 'MB';
        }
        elseif ($num >= 1000)
        {
            $num = round($num / 1024, $precision);
            $unit = 'KB';
        }
        else
        {
            $unit = 'Bytes';
        }

        //return self::format_number($num, $precision, $locale, ['after' => ' '.$unit]);
        return number_format($num, $precision).' '.$unit;
    }  

}