<?php

namespace App\Http\Controllers;

use KubAT\PhpSimple\HtmlDomParser;

class PrayTimeController extends Controller
{
    public function getCountries()
    {
        return response()->json(getCountriesBySplit());
    }

    public function getLocations(int $country_id) {
        $country = search(getCountriesBySplit(), 'country_id', $country_id)[0];
        $url = str_replace(' ', '%20', 'http://namazvakitleri.diyanet.gov.tr/assets/locations/'.$country['country_name'].'.json');
        $locations = json_decode(file_get_contents($url));

        return response()->json($locations);
    }

    public function getTimes(int $location_id) {
        $crawler = HtmlDomParser::file_get_html('https://namazvakitleri.diyanet.gov.tr/en-US/'.$location_id);
        $scrapped = $crawler->find('div[id="tab-1"]', 0);
        $locationName = $scrapped->find('caption', 0);
        preg_match_all('@(?<=for).*$@i', $locationName->innertext, $locationName);

        //Table to array
        $dataList = array();

        foreach($scrapped->find('tr') as $row) {

            $rowData = array();
            foreach($row->find('td') as $cell) {
                $rowData[] = $cell->innertext;
            }

            $dataList[] = $rowData;
            //Fix, fix, fix...
            unset($dataList[0]);
        }

        //Change key names
        $newDataList = array();
        foreach($dataList as $data) {
            $data['date'] = $data[0];
            $data['location'] = ltrim($locationName[0][0]);
            $data['imsak'] = $data[1];
            $data['sunrising'] = $data[2];
            $data['noon'] = $data[3];
            $data['mid_afternoon'] = $data[4];
            $data['evening'] = $data[5];
            $data['isha'] = $data[6];

            unset($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]);
            array_push($newDataList, $data);
        }

        return response()->json($newDataList);

    }
}
