<?php
include 'ldap.php';

$nome = "Camila";
$lastname = "da Silva Florânea";
$login = strtolower($nome.$sobrenome);
$department = "TI";
$title ="ASG";
$senha = 'Conectrom!!2023';
$telefone = "84 98152-8713";
$localizacao = "João Pessoa - PB";
$description = "vai dar certo";
$nomecompleto = $name.' '.$lastname;
$userprincipalname = $name.'.'.$lastname.$dominio;

$dn = "cn=$completo, OU=teste01,DC=local,DC=lab"; //

if ($ldapcon == true){

    $bind = ldap_bind($ldapcon, $user, $ldappass);

    ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3); // não mecher
    //ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0); // não mecher

    $info["cn"] = "$completo";  // funciona
    $info["sn"]="$lastname";  // funciona
    $info["givenname"]="$nome"; // funciona
    $info["displayname"]="$nomecompleto"; // funciona
    $info["name"]="$completo"; // funciona
    $info["title"]="$title"; // funciona
    $info["userPrincipalName"]= $userprincipalname; // funcionando
    $info["samaccountname"]= "$name.$lastname"; //funciona
    $info["department"]="$department"; // funciona
    $info["mail"]="$name.$lastname@local.com.br"; //funciona
    $info['objectclass'][0] = "top"; // não mecher
    $info['objectclass'][1] = "person"; // não mecher
    $info['objectclass'][2] = "organizationalPerson"; // não mecher
    $info['objectclass'][3] = "user"; // não mecher
    $info["physicaldeliveryofficename"]= $localizacao; //funciona
    $info["telephoneNumber"] = $telefone; //funciona
    //$info["description"] = $description; // não funciona
    $info["useraccountcontrol"]=512; // funciona
    $info['unicodepwd'] = iconv("UTF-8", "UTF-16LE", "\"".$senha."\""); // funciona

    $r = ldap_add($ldapcon,$dn, $info);

  //ldap_errno($dn);
  echo '<br>';
  echo $dn;
  ldap_close($ldapcon);

}else {

    echo "Não conectado";
    
}
