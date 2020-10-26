<?php

namespace App\Http\Controllers;

use KubAT\PhpSimple\HtmlDomParser;

class HoroscopeController extends Controller
{
    public function getHoroscopes()
    {
        return response()->json(getHoroscopesBySplit());
    }

    public function interpretation($horoscope_name) {

        $dailyInterpretation = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/'.$horoscope_name.'-burcu/')->find('div[class="horoscope-detail-tab-content"]', 0)->find('p', 0);
        $weeklyInterpretation = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/'.$horoscope_name.'-burcu-haftalik-yorum/')->find('div[class="horoscope-detail-tab-content"]', 0)->find('p', 0);
        $monthlyInterpretation = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/'.$horoscope_name.'-burcu-aylik-yorum/')->find('div[class="horoscope-detail-tab-content"]', 0)->find('p', 0);
        $yearlyInterpretation = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/'.$horoscope_name.'-burcu-yillik-yorum/')->find('div[class="horoscope-detail-tab-content"]', 0)->find('p', 0);
        $horoscopeInfo = HtmlDomParser::file_get_html('https://www.hurriyet.com.tr/mahmure/astroloji/'.$horoscope_name.'-burcu/')->find('ul[class="horoscope-menu-list"]', 0)->find('li');

        $horoscope = array(
            'horoscope_name' => $horoscope_name,
            'horoscope_image' => 'https://s.hurriyet.com.tr/static/images/mahmure/horoscopelogos/'.$horoscope_name.'-kirmizi.png',
            'horoscope_motto' => trim(substr($horoscopeInfo[0]->plaintext, strpos($horoscopeInfo[0]->plaintext, ':') + 1)),
            'horoscope_planet' => trim(substr($horoscopeInfo[1]->plaintext, strpos($horoscopeInfo[1]->plaintext, ':') + 1)),
            'horoscope_element' => trim(substr($horoscopeInfo[2]->plaintext, strpos($horoscopeInfo[2]->plaintext, ':') + 1)),
            'daily_interpretation' => $dailyInterpretation->plaintext,
            'weekly_interpretation' => $weeklyInterpretation->plaintext,
            'monthly_interpretation' => $monthlyInterpretation->plaintext,
            'yearly_interpretation' => $yearlyInterpretation->plaintext,
        );

        return $horoscope;
    }
}
