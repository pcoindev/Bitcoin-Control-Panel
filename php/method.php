<?php
	//error_reporting(-1); ini_set("display_errors", 1);
	header("Content-Type: text/plain");
	require_once "include.php";
	if (isset($_POST["method"])) {
		if ($_POST["method"] == "backupwallet" && isset($_POST["destination"])) {
			try {
				$btcconn->backupwallet($_POST["destination"]);
				echo "wallet.dat successfully backed up to ".$_POST["destination"];
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getaccount" && isset($_POST["address"])) {
			try {
				echo $btcconn->getaccount($_POST["address"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getaccountaddress" && isset($_POST["account"])) {
			try {
				echo $btcconn->getaccountaddress($_POST["account"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getaddressesbyaccount" && isset($_POST["account"])) {
			try {
				$addresses = $btcconn->getaddressesbyaccount($_POST["account"]);
				foreach ($addresses as $address) echo "$address\n";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getbalance" && isset($_POST["account"])) {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				if ($_POST["account"] == "") echo $btcconn->getbalance();
				else {
					if ($_POST["account"] == "\"\"") $_POST["account"] = "";
					echo $btcconn->getbalance($_POST["account"]);
				}
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getblockcount") {
			try {
				echo $btcconn->getblockcount();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getblocknumber") {
			try {
				echo $btcconn->getblocknumber();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getconnectioncount") {
			try {
				echo $btcconn->getconnectioncount();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getdifficulty") {
			try {
				echo $btcconn->getdifficulty();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getgenerate") {
			try {
				if ($btcconn->getgenerate()) echo "Generating"; else echo "Not generating";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "gethashespersec") {
			try {
				echo $btcconn->gethashespersec();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getinfo") {
			try {
				$info = $btcconn->getinfo();
				foreach ($info as $var => $val) echo $var.str_repeat(" ", 14 - strlen($var))." : $val\n";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getnewaddress" && isset($_POST["account"])) {
			try {
				echo $btcconn->getnewaddress($_POST["account"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getreceivedbyaccount" && isset($_POST["account"]) && isset($_POST["minconf"])) {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				echo $btcconn->getreceivedbyaccount($_POST["account"],(int)$_POST["minconf"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "getreceivedbyaddress" && isset($_POST["address"]) && isset($_POST["minconf"])) {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				echo $btcconn->getreceivedbyaddress($_POST["address"],(int)$_POST["minconf"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "gettransaction" && isset($_POST["txid"])) {
			try {
				$tx = $btcconn->gettransaction($_POST["txid"]);
				foreach ($tx as $var => $val) echo $var.str_repeat(" ", 14 - strlen($var)).": $val\n";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "help") {
			try {
				echo $btcconn->help(isset($_POST["help"]) ? $_POST["help"] : "");
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "listaccounts") {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				$accounts = $btcconn->listaccounts((int)$_POST["minconf"]);
				foreach ($accounts as $account => $bitcoins) echo $account." ".str_repeat(".", 64 - strlen($account))." $bitcoins\n";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "listreceivedbyaccount") {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				$receiveds = $btcconn->listreceivedbyaccount((int)$_POST["minconf"],(bool)$_POST["includeempty"]);
				foreach ($receiveds as $key => $received) {
					foreach ($received as $var => $val) echo $var.str_repeat(" ", 13 - strlen($var))." $val\n";
					if ($key != count($receiveds) - 1) echo "\n";
				}
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "listreceivedbyaddress") {
			try {
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				$receiveds = $btcconn->listreceivedbyaddress((int)$_POST["minconf"],(bool)$_POST["includeempty"]);
				foreach ($receiveds as $key => $received) {
					foreach ($received as $var => $val) echo $var.str_repeat(" ", 13 - strlen($var))." $val\n";
					if ($key != count($receiveds) - 1) echo "\n";
				}
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "listtransactions") {
			try {
				if (!is_numeric($_POST["count"])) $_POST["count"] = 10;
				$transactions = $btcconn->listtransactions($_POST["account"],(int)$_POST["count"]);
				foreach ($transactions as $key => $transaction) {
					foreach ($transaction as $var => $val) echo $var.str_repeat(" ", 13 - strlen($var))." $val\n";
					if ($key != count($transactions) - 1) echo "\n";
				}
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "move" && isset($_POST["fromaccount"]) && isset($_POST["toaccount"]) && isset($_POST["amount"])) {
			// This triggers error exception if insufficient funds.
			// Command line shows: error: {"code":-6,"message":"Account has insufficient funds"}
			// Exception $e does not seem to provide this information and therefore it doesn't seem possible to output the specific error.
			// Any ideas?
			try {
				if (!is_numeric($_POST["amount"])) $_POST["amount"] = 0;
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				echo $btcconn->move($_POST["fromaccount"],$_POST["toaccount"],(float)$_POST["amount"],(int)$_POST["minconf"],$_POST["comment"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "sendfrom" && isset($_POST["account"]) && isset($_POST["address"]) && isset($_POST["amount"])) {
			try {
				if (!is_numeric($_POST["amount"])) $_POST["amount"] = 0;
				if (!is_numeric($_POST["minconf"])) $_POST["minconf"] = 1;
				echo $btcconn->sendfrom($_POST["account"],$_POST["address"],(float)$_POST["amount"],(int)$_POST["minconf"],$_POST["comment"],$_POST["commentto"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "sendtoaddress" && isset($_POST["address"]) && isset($_POST["amount"])) {
			try {
				if (!is_numeric($_POST["amount"])) $_POST["amount"] = 0;
				echo $btcconn->sendtoaddress($_POST["address"],(float)$_POST["amount"],$_POST["comment"],$_POST["commentto"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "setaccount" && isset($_POST["address"]) && isset($_POST["account"])) {
			try {
				$btcconn->setaccount($_POST["address"],$_POST["account"]);
				echo $btcconn->getaccount($_POST["address"]);
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "setgenerate" && isset($_POST["generate"]) && isset($_POST["genproclimit"])) {
			try {
				$btcconn->setgenerate((bool)$_POST["generate"],(int)$_POST["genproclimit"]);
				echo "Success";
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "stop") {
			try {
				echo $btcconn->stop();
			} catch (Exception $e) { btcerr($e); }
		}
		if ($_POST["method"] == "validateaddress" && isset($_POST["address"])) {
			try {
				$validate = $btcconn->validateaddress($_POST["address"]);
				foreach ($validate as $var => $val) echo $var.str_repeat(" ", 7 - strlen($var))." : $val\n";
			} catch (Exception $e) { btcerr($e); }
		}
	}
?>