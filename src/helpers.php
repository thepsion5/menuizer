<?php

if(!function_exists('str_splice')) {
    function str_splice($delimiter, &$string)
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
}

if(!function_exists('str_to_assoc_array')) {
    function str_to_assoc_array($paramDelimiter, $valueDelimiter, $string)
    {
        $finalizedParams = array();
        $paramsAndValues = explode($paramDelimiter, $string);
        foreach($paramsAndValues as $paramAndValue) {
            $key = str_splice($valueDelimiter, $paramAndValue);
            if($key) {
                $finalizedParams[$key] = $paramAndValue;
            }   else {
                $finalizedParams[] = $paramAndValue;
            }
        }
        return $finalizedParams;
    }
}

if(!function_exists('array_to_html_attrs')) {
    function array_to_html_attrs(array $input)
    {
        $htmlAttrs = array();
        foreach($input as $property => $value) {
            $htmlAttrs[] = (is_numeric($property)) ? $value : "$property=\"$value\"";
        }
        return implode(' ', $htmlAttrs);
    }

}