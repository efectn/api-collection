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

    public function getCurrencies()
    {
        $crawler = HtmlDomParser::file_get_html('https://www.x-rates.com/graph/?from=USD&to=ARS&amount=1');
        $scrapped = $crawler->find("ul[class='currencyList currencygraph'] > li > a");

        $i = 0;
        foreach ($scrapped as $currency) {
            preg_match_all("@<a href='.*?'>([^<]+)</a>@i", $currency->outertext, $out);

            $currencyList[$i] = array(
                'currency_id' => substr($currency->href, strpos($currency->href, "=") + 1),
                'currency_name' => $out[1][0]
            );
            $i++;
        }

        return response()->json($currencyList);
    }

    public function getCurrency(string $from)
    {
        $crawler = HtmlDomParser::file_get_html('https://www.x-rates.com/table/?from=' . $from . '&amount=1');
        $scrapped = $crawler->find('table[class="tablesorter ratesTable"] > tbody', 0);

        $rates = array();
        $i = 0;
        foreach ($scrapped->find('td[class="rtRates"] > a') as $currency) {
            preg_match_all("@<a href='.*?'>([^<]+)</a>@i", $currency->outertext, $out);
            $name = substr($currency->href, strpos($currency->href, "to") + 3);
            if ($name != 'TRY') {
                array_push($rates, [$name => $out[1][0]]);
            }
            $i++;
        }

        return response()->json(
            array(
                'base' => $from,
                'timestamp' => $crawler->find('span[class="ratesTimestamp"]', 0)->plaintext,
                'rates' => $rates,
            )
        );
    }
}
