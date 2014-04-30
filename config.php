<?php
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
//USER CONFIGURABLE
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
//FEATURES
date_default_timezone_set('Europe/Berlin'); //Possible Timezones: http://www.php.net/manual/de/timezones.php
$DEBUG = TRUE; //Should the program Print Debug information
$simulate = FALSE; //RUNS IN SIMULATION MODE, NO TRADES ARE MADE just PRINT OUTPUT
$exchange = "E"; //Pick an exchange to run on
$BTCE = TRUE;


//Maximum play amounts (that's play not investment) this is after all technically a beta idea

$maxUSD = 500; //The maximum amount of USD to use -> includes B held * last price!
$maxBTC = 1; //The maximum amount of BTC to use

//Send email reports when orders are placed
$emailRCPTo = "SET IN KEY.PHP INCLUDE FILE";
$btceKey = 'FILL ME'; // your API-key
$btceSecret = 'FILL ME'; // your Secret-key
$emailSubject = "BTCbot Trade on {$exchange}";
 

?>