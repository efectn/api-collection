<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use KubAT\PhpSimple\HtmlDomParser;

class EarthquakeController extends Controller
{
    public function getEarthquakes(int $limit = 1000)
    {
        //Set cache if cache doesn't exist
        if(!Cache::get('page_number')) {
            $crawlerPageCount = HtmlDomParser::file_get_html('http://sc3.koeri.boun.edu.tr/eqevents/events.html');
            $scrappedPageCount = $crawlerPageCount->find('td[width="70px"]', 0)->innertext;
            Cache::put('page_number', intval(substr($scrappedPageCount, strpos($scrappedPageCount, "/") + 1)), '3600');
        }

        if(!Cache::get('earthquakes')) {
            //Get pages and create array
            $allEarthquakes = array();
            for ($i = 0; $i < Cache::get('page_number'); $i++) {
                if ($i == 0) {
                    array_push($allEarthquakes, getEarthquakesBySplit('http://sc3.koeri.boun.edu.tr/eqevents/events.html'));
                } else {
                    array_push($allEarthquakes, getEarthquakesBySplit('http://sc3.koeri.boun.edu.tr/eqevents/events' . $i . '.html'));
                }
            }
            Cache::put('earthquakes', $allEarthquakes, '1800');
        }

        return response()->json(array_slice(earthquake_merge(Cache::get('earthquakes')), 0, $limit));
    }
}
