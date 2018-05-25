<?php
require_once("class.bd.php");

class variables extends bd
{

function __construct($id = 0)          
    {
      parent::__construct();
      
     

    }


    const COLOR_NOT_SENT = "#585858";
    const COLOR_SENT = "#0c7ed4";
    const COLOR_ERROR = "#D26380";
    const COLOR_CONFIRMED = "#3fa785";


}

?>