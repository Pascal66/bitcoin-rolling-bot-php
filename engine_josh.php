<?php
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
//Josh's Engine
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////


	if ($JOSH){
		//$joshAmount = 5; //In BTC
		//$joshThreshold = 5; //In USD
		//$joshStopLoss = .05; //as a percentage
		//$joshReBuy = .05; //as a percentage
		if ( !@$joshTicker ) $joshTicker =  $ticker['ticker']['last'];
	////////////////////////////////////////////////////////////////////
	//Reset Funds and print Header Block
		$USDremaining = $USD;
		$BTCremaining = $BTC;
		print "------------------- JOSH's ENGINE TRADE BLOCK -------------------\n";
		print "Threshold: Fees:{$exchangeCommision}% Trades:{$joshThreshold}";
		$tmp1 = $joshTicker + $joshThreshold; $tmp2 = $joshTicker - $joshThreshold;
		if (@$DEBUG ) print "Josh-Targets: Over:\${$tmp1} Tick:\${$joshTicker} Under:\${$tmp2}\n";
		print "Checking JOSH Buy Funds and Balance: ";
	//DEBUG need to get last two order ID's to check if they filled?
	////////////////////////////////////////////////////////////////////
	//Reset the ticker
		if ( $ticker['ticker']['last'] > $joshTicker + $joshThreshold || $ticker['ticker']['last'] < $joshTicker - $joshThreshold ){
			$joshTicker =  $ticker['ticker']['last'];
		}
	////////////////////////////////////////////////////////////////////
	//Cancel all orders
		cancelOrders($exchangeBuySell[0]); //cancel current buy orders to replace;
		cancelOrders($exchangeBuySell[1]); //cancel current sell orders to replace;
	
	////////////////////////////////////////////////////////////////////
	//Setup Buy orders
		if ( 'josh' == 'cool' && $USD > $joshAmount*($ticker['ticker']['last']-$joshThreshold) ){ //BUY
			print "\n";
			$executeTrade = TRUE; //turn on trading
			
			$type[$countOrder] = $exchangeBuySell[0]; //The type of trade
			$rate[$countOrder] = floor100($ticker['ticker']['last'] - $joshThreshold);
			$amount[$countOrder] = $joshAmount; //the amount of the trade
			$USDremaining = $USDremaining - $rate[$countOrder] * $amount[$countOrder] ;
			print "Buying {$amount[$countOrder]}B at a rate of \${$rate[$countOrder]} \${$USDremaining} left.\n";
			$countOrder++;
		} else print "No Buy Trades.\n";
	////////////////////////////////////////////////////////////////////
	//Setup Sell Orders
		if ( 'josh' == 'cool' && $BTC > $joshAmount ){ //SELL
			print "\n";
			$executeTrade = TRUE; //turn on trading
			
			$type[$countOrder] = $exchangeSellSell[1]; //The type of trade
			$rate[$countOrder] = ceil100($ticker['ticker']['last'] + $joshThreshold);
			$amount[$countOrder] = $joshAmount; //the amount of the trade
			$BTCremaining = $BTCremaining - $amount[$countOrder];
			print "Selling {$amount[$countOrder]}B at a rate of \${$rate[$countOrder]} \${$BTCremaining} left.\n";
			$countOrder++;
		} else print "No Sell Trades.\n";
	}













?>