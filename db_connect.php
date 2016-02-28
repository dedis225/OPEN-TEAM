<?php
/*
 * 	Connexion à la Base de données
 * 
 */

//ici les parametres pour la connexion
$host="localhost"; 
$base="openteam";    
$passe="temporaire"; 
$user="root";
  
//on effectue la connexion
@mysql_connect("$host","$user","$passe");
 
//Selection de la base de donnees qui porte le meme nom que votre login
$select_base=@mysql_selectdb("$base"); 

//Si la connexion echoue
 
 if (!$select_base) 
{

//Afficher la ligne suivante
?>
<center>
  <p><font size="2"><big> <font color="#CC0000"><b><font face="Arial, Helvetica, sans-serif">Erreur
              d'acc&egrave;s au Site Web !<br>
              <br>
              Espcace reserv&eacute;, veuillez contacter l'administrateur du Site SVP
              ! </font></b></font></big></font><big><br>
    <br>
    <br>
    <br>
  </big> </p>
</center>
<?php

exit();
}
?>
