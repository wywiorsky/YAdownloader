<?php

require_once('/./controler.class.php');
require_once('/../inc/downloadPhotos.class.php');

class mainControler extends Controler{
    
    public $download;
    
public function __construct(){
        
    parent::__construct();
       
    $this->download = new downloadPhotos;
        
    }
    
 
public function GetPhotos($params){ 
    
     

    $data = $this->download->GetByApi($params);
    
    if($data != false){
          
       $photos_number = $this->download->SavePictures($data);
       $this->tpl->assign('photos',$photos_number);
       $this->tpl->display('index.tpl');
        
    }
   
return false;
    
}
    
public function DisplayForm(){
    
     $this->tpl->display('index.tpl');
    
}
    
 
}
