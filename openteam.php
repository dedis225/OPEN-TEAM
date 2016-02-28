#!/usr/bin/php
<?php
/*
|---------------------------------------------------------------
| 							Money_API
|---------------------------------------------------------------
*/
//include 'grep.php';
//include 'debanir.php';
$ban = 0;
$ip_ban =array();
while(1)
{

	//include 'grep.php';
	require('db_connect.php');
    $sql="select * from inbox where readed='false'";
	$result=mysql_query($sql);
	
	$keyword = "";
	$Var_1 = "";
	
	while($tab_msg = mysql_fetch_array($result))
	{
		$ReceivingDateTime=$tab_msg[1];
		$SenderNumber=$tab_msg[3];
		$TextDecoded_1=trim($tab_msg[8]);
		list($TextDecoded, $Var) = explode("*",$TextDecoded_1);
		$ID=$tab_msg[9];
		$keyword=  strtolower($TextDecoded);
		$Var_1=  strtolower($Var);
		$number= substr($SenderNumber, 0,6);	

// Vérification que le numero d'envoi est un numero orange
	# code...
//include 'bascule.php';




if ($number =='+22507' || $number =='+22508' || $number =='+22509' || $number =='+22547' || $number =='+22548' || $number =='+22549' || $number =='+22557' || $number =='+22558' || $number =='+22559' || $number =='+22577' || $number =='+22578' || $number =='+22579')
{ 
	# code...	
		switch ($keyword)
		{
			case "bascule":
				include 'bascule.php';
			break;
			/* Fin du script de gestion des infos de suivi des bus */
                     
             case "deban":
				include 'debanir.php';
				$ban = 1;
			break;
			 

			default:
				$date = gmdate("Y-m-d H:i:s");
				$message ="";
				$text = utf8_decode("Désolé votre message incorrect");
				$sql_0="insert into outbox(InsertIntoDB, DestinationNumber, TextDecoded, DeliveryReport) values('$date', '$SenderNumber', '$text', 'yes')";
				$result_0=mysql_query($sql_0);
				echo "$Var_1";

				$sql_dump = "INSERT INTO menace(ip,type) VALUES ('$Var_1','$text')";
   				$result_2=mysql_query($sql_dump);
                
		}
		$sql_0_="update inbox set readed='lol' where ID='$ID'";
		$result_0_=mysql_query($sql_0_);

	 }
     else
     {
     
     }
	}
	sleep(1);
	if($keyword!="deban"){
		if($ban==0 && sizeof($ip_ban)==0){
			include 'fail2ban.php';
			$ip_ban[0] = $Var_1;
		}else if($ban!=0 && sizeof($ip_ban)!=0 ){
			for($e = 0;$e<sizeof($ip_ban);$e++){
				if($ip_ban[$e]!=$Var_1 && strlen($Var_1)!=0){
					include 'fail2ban.php';
					$ip_ban[$e] =$Var_1;
				}
			}
		}
	}
}


?>
