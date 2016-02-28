#!/usr/bin/php

<?php
 require('db_connect.php'); // Connexion la base de donnée
 //ssh
$ssh="ssh risk@192.168.1.40";

$date = gmdate("Y-m-d H:i:s");
 // lecture du fichier de connection par ssh auth.log

$output = shell_exec($ssh. ' -C "grep "WARNING" /var/log/fail2ban.log | grep "Ban""'); 

//recuperation du nombre ligne qui sera mis dans le chiser out.txt 
$input = shell_exec($ssh. ' -C grep "WARNING" /var/log/fail2ban.log | grep "Ban" | cut -d" "  -f7 '); 
$input_3 = shell_exec($ssh. ' -C grep "WARNING" /var/log/fail2ban.log | grep "Ban" | cut -d" "  -f7 | cat | wc -l');
//echo $input;
$i = 0;
foreach (explode("\n", $input) as $nombre_de_lignes)
 {
 	/*$input_4 = shell_exec('cut -d" " -f1 $nombre_de_lignes'); */
 	$input_5= "SELECT * from failtoban WHERE ip_failtoban='".$nombre_de_lignes."'";
 	$input_6=mysql_query($input_5);
 	
 	//echo $nombre_de_lignes."\n";
 	/*if($input_3==$i){
 		break;
 	}*/
 	//$i++;

 	$info = 0;
 	while ($row = mysql_fetch_assoc($input_6)) {
 		$info ++;
 		if($row["date_failtoban"] != $date){
 			$sql_0= "DELETE FROM failtoban WHERE ip_failtoban = '$nombre_de_lignes'";
 			$result_0=mysql_query($sql_0);
 			$sql_0="INSERT INTO failtoban(date_failtoban,ip_failtoban,etat) VALUES('$date','$nombre_de_lignes','ban')";
 			$result_0=mysql_query($sql_0);
 		}


 	}

 	if($info!=0){
 		//echo $info;
 	}
 	else {

 		$sql_0="INSERT INTO failtoban(date_failtoban,ip_failtoban,etat) VALUES('$date','$nombre_de_lignes','ban')";
 		echo $sql_0;
 		$result_0=mysql_query($sql_0);
 		$text = utf8_decode("FAIL2BAN!!! Ip $nombre_de_lignes à été bani du réseau\n Faites DEBAN*$nombre_de_lignes pour le débanir");
   				//$textecrypt= persoCrypt(strtoupper($text), 'c');
   		$sql_1="INSERT INTO outbox(InsertIntoDB,DestinationNumber,TextDecoded,DeliveryReport) VALUES('$date','+22549092087', '$text', 'yes')";
   		

   		$result_1=mysql_query($sql_1);

   		$sql_dump = "INSERT INTO menace(type) VALUES ('$text')";
   		$result_2=mysql_query($sql_dump);
   		
   		$ban = 1;
 	}
 	$i++;
 	if($i==$input_3){
 		break;
 	}

 	
 
 }
// echo $i;
//echo("$input_4");
?>