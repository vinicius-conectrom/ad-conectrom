<?php
    include 'ldap.php';
    
    $givename = $_POST['p-nome'];
    $surname = $_POST['s-nome'];
    $displayname = $givename.' '.$surname;
    $login_rede = strtolower($_POST['login_rede']);
    $fone = $_POST['fone'];
    $funcao = $_POST['funcao'];
    $local_trabalho = $_POST['local_trabalho'];
    $setor_trabalho = $_POST['setor_trabalho'];
    $mail = "$login_rede@conectrom.com.br";
    $senha = 'Conectrom!!2023';
    $grupo = $_POST['grupo'];
    $dn = "cn=$displayname,OU=teste01,DC=local,DC=lab";

    if ($ldapcon == true){

        $bind = ldap_bind($ldapcon, $user, $ldappass);
    
        ldap_set_option($ldapcon, LDAP_OPT_PROTOCOL_VERSION, 3); // não mecher
        //ldap_set_option($ldapcon, LDAP_OPT_REFERRALS, 0); // não tirar o comentário
    
        $info["cn"] = $givename.' '.$surname;;  // funciona
        $info["sn"]= $surname;  // funciona
        $info["givenname"]= $givename; // funciona
        $info["displayname"]= $givename.' '.$surname; // funciona
        $info["name"]= $givename.' '.$surname; // funciona
        $info["title"]= $funcao; // funciona
        $info["userPrincipalName"]= $login_rede.$dominio; // funcionando
        $info["samaccountname"]= $login_rede; //funciona
        $info["department"]= $setor_trabalho; // funciona
        $info["mail"]= $mail; //funciona
        $info['objectclass'][0] = "top"; // não mecher
        $info['objectclass'][1] = "person"; // não mecher
        $info['objectclass'][2] = "organizationalPerson"; // não mecher
        $info['objectclass'][3] = "user"; // não mecher
        $info["physicaldeliveryofficename"]= $local_trabalho; //funciona
        $info["telephoneNumber"] = $fone; //funciona
        //$info["description"] = $description; // não funciona
        $info["useraccountcontrol"]=512; // funciona
        $info['unicodepwd'] = iconv("UTF-8", "UTF-16LE", "\"".$senha."\""); // funciona
        $r = ldap_add($ldapcon,$dn, $info);



        $group_dn = "CN=TI,CN=Groups,DC=local,DC=lab"; // DN do grupo "TI"
        $user_dn = "CN=marta jogadora,$ldap_base_dn"; // DN do usuário "bruno" em "teste01"
        $resultado = ldap_mod_add($ldapcon, $group_dn, array("member" => $user_dn)); // Adiciona o usuário ao grupo
        
        
        
    
    
        //ldap_errno($dn);
        ldap_close($ldapcon);

        header('Location: http://192.168.56.110:7171/index.php');
    
    }else {
    
        echo "Não conectado";
        
    }
