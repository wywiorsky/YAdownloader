<?php

require_once('/../../settings.php');
require_once('/../inc/api.class.php');
require_once('/../inc/iptc.class.php');

class downloadPhotos {

    public $api;
    public $files_dir_path;

    function __construct() {

        $this->api = new Api($GLOBALS['key']);
        $this->files_dir_path = $GLOBALS['path'];
    }

    public function GetByApi($params) {


        $allowed_params = array('page', 'category', 'sort', 'order', 'output', 'aucmaxprice');


        foreach ($params as $key => $value) {

            if (in_array($key, $allowed_params)) {

                $config[$key] = $value;
            }
        }


        // default values

        $config['page'] = isset($config['page']) ? $config['page'] : '1';
        $config['category'] = isset($config['category']) ? $config['category'] : '2084008474';
        $config['sort'] = isset($config['sort']) ? $config['sort'] : 'end';
        $config['order'] = isset($config['order']) ? $config['page'] : 'a';
        $config['output'] = isset($config['output']) ? $config['output'] : 'json';
        $config['aucmaxprice'] = isset($config['aucmaxprice']) ? $config['aucmaxprice'] : '100000';



        $data = $this->api->getCategoryContent($config);

        if (isset($data['ResultSet'])) {

            return $data; // Everything works
        }

        if (strpos($data, 'Error') !== false) {

            die($data);
        }

        return false;
    }

    public function SavePictures($arr_content) {


        if (!file_exists($this->files_dir_path)) { // check isset directory
            mkdir($this->files_dir_path, 0777, true);
        }


        $auctions = $arr_content['ResultSet']['Result']['Item'];

        $counter = 0;

        foreach ($auctions as $value) {

            $content = file_get_contents($value['Image']);       // downaload photo
            $extension = end(explode('.', $value['Image'])); //file extension


            if (file_exists($this->files_dir_path . $value['AuctionID'] . '.' . $extension)) {

                continue;
            }

            file_put_contents($this->files_dir_path . $value['AuctionID'] . '.' . $extension, $content); //save photo 

            if (file_exists($this->files_dir_path . $value['AuctionID'] . '.' . $extension)) {

                $objIPTC = new IPTC($this->files_dir_path . $value['AuctionID'] . '.' . $extension); // IPTC Class for set url as title metatag
                $objIPTC->setValue(IPTC_CAPTION, $value['AuctionItemUrl']);

                $counter++;
            }
        }


        return $counter;
    }

}
