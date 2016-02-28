<?php
//connection via ssh
require('db_connect.php');
$ssh="ssh root@192.168.1.40";

// condition avec le message bascule

$ip= "SELECT * from failtoban WHERE ip_failtoban='$Var_1'";
$ip_2=mysql_query($ip);
$date = gmdate("Y-m-d H:i:s");

	if ($ip_2 != 0 ) {
		exec($ssh." -Ct './ipban.sh $Var_1' ");
		$text = utf8_decode("Ip $Var_1 à été débani");
   		$sql_1="INSERT INTO outbox(InsertIntoDB,DestinationNumber,TextDecoded,DeliveryReport) VALUES('$date','+22549092087', '$text', 'yes')";
   		$result_1=mysql_query($sql_1);
   		$sql_3= "UPDATE failtoban SET etat='deban' WHERE ip_failtoban='$Var_1'";
   		echo $sql_3;
   		$result_2=mysql_query($sql_3);
   		 if(!$result_2 ) {
               die('Could not delete data: ' . mysql_error());
            }


        $sql_dump = "INSERT INTO menace(type) VALUES ('$text')";
   		$result_2=mysql_query($sql_dump);
	}

	else
	{
	}

		

echo($Var_1);
?>