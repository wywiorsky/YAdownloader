<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mainControler
 *
 * @author win
 */



class Controler{
 
    public $tpl;
    
    
public function __construct(){ 
    
    
require_once '/../smarty/Smarty.class.php';

$this->tpl = new Smarty;

$this->tpl->debugging = false;
$this->tpl->caching = false;
$this->tpl->assign('path_directory',$GLOBALS['directory']);


    
}
 
}
