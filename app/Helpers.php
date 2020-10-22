<?php

use KubAT\PhpSimple\HtmlDomParser;

function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}


 function getCountriesBySplit(): Array {
    $crawler = HtmlDomParser::file_get_html('https://namazvakitleri.diyanet.gov.tr/en-US/');
    $scrapped = $crawler->find('select[name="country"]', 0)->innertext;

    $countryList = array();
    $countries = array_values(array_filter(explode('  ', $scrapped))); // Create country list array

    foreach ($countries as $country) {
        preg_match_all('@<option( value="\d+")>(.+)<\/option>@i', $country, $result); // Split optiıns.
        $result[1][0] = preg_replace('~\D~', '', $result[1][0]); // String to integer

        $result['country_id'] = $result[1][0];
        $result['country_name'] = $result[2][0];

        unset($result[0], $result[1], $result[2]); //Delete unnecessary array elements
        array_push($countryList, $result); // Re-list array keys
    }

    array_multisort(array_column($countryList, 'country_id'), SORT_ASC, $countryList);
    unset($countryList[204], $countryList[205]);

    return $countryList;
 }
