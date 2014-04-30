<?php
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
//50/50 Balance Engine
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////Balance ENGINE/////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//DEBUG you may want to use threshold crossing for these to prevent mass ordering.
	if ( $BALANCE ){
	////////////////////////////////////////////////////////////////////
	//Calculate distance, difference, portfolio balance
		$distanceFromHigh = $ticker['ticker']['high'] - $ticker['ticker']['last'];
		$distanceFromLow = $ticker['ticker']['last'] - $ticker['ticker']['low'];
		$spreadHighLow = $ticker['ticker']['high'] - $ticker['ticker']['low'];
	
		//Calculate new preffered balance amounts
		$reBalanceBTC = floor(($distanceFromLow/$spreadHighLow)*100)/100;
		$reBalanceUSD = 1-$reBalanceBTC; //Prefer USD during rebalance
		
		$currentBalanceBTC = floor(($BTCB/$BTCT)*100)/100;
		$currentBalanceUSD = 1-$currentBalanceBTC; //$USDB/$USDT;
		
		$reBalanceUSDDisplay = $reBalanceUSD*100;
		$reBalanceBTCDisplay = $reBalanceBTC*100;
		$currentBalanceUSDDisplay = $currentBalanceUSD*100;
		$currentBalanceBTCDisplay = $currentBalanceBTC*100;
	
		print "------------ Portfolio Balancing Information  ------------\n";
		$tmp1 = round($distanceFromHigh,2);$tmp2 = round($distanceFromLow,2);$tmp3 = round($spreadHighLow,2);
		print "From High:{$tmp1} From Low:{$tmp2} Spread:{$tmp3}\n";
		$tmp1 = $tmp2 = $tmp3 = NULL;
		
		print "Current Balance: USD:{$currentBalanceUSDDisplay}% BTC:{$currentBalanceBTCDisplay}%\n";
		print "Target  Balance: USD:{$reBalanceUSDDisplay}% BTC:{$reBalanceBTCDisplay}%\n";
	
		////////////////////////////////////////////////////////////////////
		//Setup Buy orders
		$USDremaining = $USD;
		$balanceBuy = FALSE;
		print "------------------- Mini-Balance-Trade Block -------------------\n";
		print "Checking Micro-Balance Buy Funds and Balance: ";
		if ( $BALANCE && ($USDT*($currentBalanceUSD-$reBalanceUSD))/($ticker['ticker']['last'] - $threshold)  > 0 && $balanceSell = FALSE ){ //Trade USD for BTC
			print "Increasing BTC - Decreasing USD. \n";
			$executeTrade = TRUE; //turn on trading
			$balanceBuy = TRUE; //Let the next part know we bought
			$type[$countOrder] = $exchangeBuySell[0]; //The type of trade
			$rate[$countOrder] = floor100($ticker['ticker']['last'] - $threshold);
			$amount[$countOrder] = round( ($USDT*($currentBalanceUSD-$reBalanceUSD))/$rate[$countOrder] ,2); //the amount of the trade
			$amount[$countOrder] = min($amount[$countOrder],$balanceAmount);
			$USDremaining = $USDremaining - $rate[$countOrder] * $amount[$countOrder] ;
			print "Buying {$amount[$countOrder]}B at a rate of \${$rate[$countOrder]} \${$USDremaining} left.\n";
			$balanceThresholdBuy = $rate[$countOrder];
			$countOrder++;
		} else print "No Buy Trades.\n";
		////////////////////////////////////////////////////////////////////
		//Setup Sell Orders
		$BTCremaining = $BTC;
		$balanceSell = FALSE;
		print "Checking Micro-Balance Sell Funds and Balance: ";
		if ( $BALANCE && $BTCT*($currentBalanceBTC-$reBalanceBTC) > 0  && $balanceBuy = FALSE ){ //Trade BTC for USD
			print "Increasing USD - Decreasing BTC. \n";
			$executeTrade = TRUE; //turn on trading
			$balanceSell = TRUE;
			$type[$countOrder] = $exchangeBuySell[1]; //The type of trade
			$rate[$countOrder] = ceil((($ticker['ticker']['last'] + $threshold))*100)/100;
			$amount[$countOrder] = round( ($BTCT*($currentBalanceBTC-$reBalanceBTC)) ,2); //the amount of the trade
			$amount[$countOrder] = min($amount[$countOrder],$balanceAmount);
			$BTCremaining = $BTCremaining - $amount[$countOrder] ;
			print "Selling {$amount[$countOrder]}B at a rate of \${$rate[$countOrder]} \${$USDremaining} left.\n";
			$thresholdSell = $rate[$countOrder];
			$countOrder++;
		} else print "No Sell Trades.\n";
	}














?>