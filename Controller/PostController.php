<?php
require 'SqlWrapper.php';
class PostController extends GlobalFunctions
{
    private $sqlWrapper;
    public function __construct()
    {
        $this->sqlWrapper = new SqlWrapper();
    }

    


   
    


    
    public function __destruct()
    {
        $this->sqlWrapper = NULL;
    }
}
