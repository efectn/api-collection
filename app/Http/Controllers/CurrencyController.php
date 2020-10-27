<?php

namespace App\Http\Controllers;

use KubAT\PhpSimple\HtmlDomParser;

class CurrencyController extends Controller
{
    public function tcmbCurrencies()
    {
        $url = 'https://www.tcmb.gov.tr/kurlar/today.xml';

        $xmlObject = simplexml_load_string(file_get_contents($url));

        $jsonString = json_encode($xmlObject);
        $jsonArray = json_decode($jsonString, true);

        return response()->json($jsonArray);
    }

    public function getCurrencies() {
        $crawler = HtmlDomParser::file_get_html('https://www.x-rates.com/graph/?from=USD&to=ARS&amount=1');
        $scrapped = $crawler->find('select[class="ccDbx"]', 1);
        return ($scrapped->outertext);
    }
}
