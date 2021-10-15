<?php
require_once 'vendor/autoload.php';

use App\FileLogger;

try{
    $logger = new FileLogger();

   $logger->info("hellow");


}catch (Exception $e){
    echo  $e->getLine();
}





