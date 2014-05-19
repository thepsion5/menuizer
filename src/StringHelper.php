<?php

namespace Thepsion5\Menuizer;

class StringHelper
{
    public static function splice($delimiter, &$string)
    {
        $position = strpos($string, $delimiter);
        if($position > 0) {
            $spliced = substr($string, 0, $position);
            $string = substr($string, $position+1);
        } else {
            $spliced = null;
        }
        return $spliced;
    }

    public static function toAssociativeArray($string, $paramDelimiter = ',', $valueDelimiter = '=')
    {
        $finalizedParams = array();
        $paramsAndValues = explode($paramDelimiter, $string);
        foreach($paramsAndValues as $paramAndValue) {
            $key = self::splice($valueDelimiter, $paramAndValue);
            if($key) {
                $finalizedParams[$key] = $paramAndValue;
            }   else {
                $finalizedParams[] = $paramAndValue;
            }
        }
        return $finalizedParams;
    }

    public static function arrayToHtmlAttributeString(array $input)
    {
        $htmlAttrs = array();
        foreach($input as $property => $value) {
            $htmlAttrs[] = (is_numeric($property)) ? $value : "$property=\"$value\"";
        }
        return implode(' ', $htmlAttrs);
    }
}
