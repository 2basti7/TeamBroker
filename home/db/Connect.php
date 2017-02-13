<?php
class connect{
	function con(){
		$serverName = "BTN4NV04\PROJEKTE2016"; //serverName\instanceName
		$connectionInfo = array( "Database"=>"TeamBroker");
		$conn = sqlsrv_connect( $serverName, $connectionInfo);

		if( $conn ) {
			//echo "Connection established.<br />";
		}else{
			echo "Connection could not be established.<br />";
			die( print_r( sqlsrv_errors(), true));
		}
		return $conn;
	}
}
?>