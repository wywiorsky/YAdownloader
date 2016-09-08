<?php

class Api {

    var $key;

    function __construct($key) {

        $this->key = $key;
    }

    public function getCategoryContent($config) {


        $config['appid'] = $this->key;

        $params = http_build_query($config);

        $url = 'http://auctions.yahooapis.jp/AuctionWebService/V2/categoryLeaf?';
        $url.= $params;


        $result = file_get_contents($url);


        $clean_result = str_replace('loaded(', '', $result);
        $clean_result = str_replace('})', '}', $clean_result);

        $result = json_decode($clean_result, true);

        if ($result['ResultSet']['Result']['Item']) {

            return $result;
        }



        return ('Error - API doesnt work');
    }

}
