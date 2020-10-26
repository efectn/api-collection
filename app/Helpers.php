<?php
header('Content-Type: text/html; charset=utf-8');

use KubAT\PhpSimple\HtmlDomParser;

function mb_strtolower_turkish($word){
    $find 	= array("I", 'Ç');
    $change  = array("ı", 'ç');
    $word	= str_replace($find, $change, $word);
    $word	= mb_strtolower($word, 'UTF-8');
    return $word;
}

function slugOlustur($string)
{
    //Türkçeye özgü harfleri değiştirme
    $string = str_replace('ü','u',$string);
    $string = str_replace('Ü','U',$string);

    $string = str_replace('ğ','g',$string);
    $string = str_replace('Ğ','G',$string);

    $string = str_replace('ş','s',$string);
    $string = str_replace('Ş','S',$string);

    $string = str_replace('ç','c',$string);
    $string = str_replace('Ç','C',$string);

    $string = str_replace('ö','o',$string);
    $string = str_replace('Ö','O',$string);

    $string = str_replace('ı','i',$string);
    $string = str_replace('İ','I',$string);

    return $string;
}

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

 function getHoroscopesBySplit() {
     $crawler = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/');
     $scrapped = $crawler->find('span[class="zodiac-widget-item-name"]');

     $horoscopes = array();

     foreach($scrapped as $horoscope) {
         $horoscope = mb_strtolower(str_replace('&#199;', 'c', $horoscope->plaintext), 'UTF-8');
         array_push($horoscopes, slugOlustur($horoscope));
     }

     return $horoscopes;
 }

function get_with_curl_or_404($url){
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($handle);

    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    curl_close($handle);

    if($httpCode == 404 || !$response) { // arbitrary choice to return 404 when anything went wront
        return 404;
    } else {
        return $response;
    }
}

function getEarthquakesBySplit($url): Array {
    $crawler = HtmlDomParser::file_get_html($url);

    $dataList = array();
    foreach ($crawler->find('tr[onclick]') as $row) {
        $rowData = array();
        foreach($row->find('td') as $cell) {
            $rowData[] = $cell->innertext;
        }
        $dataList[] = $rowData;
    }


    $newDataList = array();
    foreach($dataList as $data) {
        //dd($data);
        preg_match_all('@<a\s+(?:[^>]*?\s+)?href=(["\'])(.*?)\1@i', $data[9], $out);
        $id = explode('/', $out[2][0])[1];

        $data['earthquake_id'] = $id;
        $data['earthquake_image'] = 'http://sc3.koeri.boun.edu.tr/eqevents/event/'.$id.'/'.$id.'-map.jpeg';
        $data['time_utc'] = $data[0];
        $data['mag'] = $data[1];
        $data['mag_type'] = $data[2];
        $data['latitude'] = $data[3];
        $data['longitude'] = $data[4];
        $data['depth'] = $data[5];
        $data['region_name'] = $data[6];
        $data['a_or_m'] = $data[7];
        $data['last_update'] = $data[8];
        $data['kml_stations'] = 'http://sc3.koeri.boun.edu.tr/eqevents/event/'.$id.'/events.kml';
        $data['kml_event'] = 'http://sc3.koeri.boun.edu.tr/eqevents/eq_events?get_kml=True&event_id='.$id.'';

        unset($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9]);
        array_push($newDataList, $data);
    }

    return $newDataList;
}

function earthquake_merge(array $array) {
    return call_user_func_array('array_merge', $array);
}

