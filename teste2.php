<?php
include 'ldap.php';

$ldap_base_groups = 'CN=Groups,DC=local,DC=lab';

if ($ldapcon) {
    // Autenticação no servidor LDAP
    $ldap_bind = ldap_bind($ldapcon, $user, $ldappass);
    if ($ldap_bind) {
        // Pesquisa por todos os grupos no diretório LDAP
        $search_filter = '(objectClass=group)';
        $result = ldap_search($ldapcon, $ldap_base_groups, $search_filter);
        $entries = ldap_get_entries($ldapcon, $result);
        
        // Imprime os grupos encontrados em uma tabela HTML
        echo '<select name="select">';
        for ($i = 0; $i < $entries['count']; $i++) {
            echo '<option value="' . $entries[$i]['dn'] . '">' . $entries[$i]['cn'][0] . '</option>';
            // echo '<option value="">' . $entries[$i]['cn'][0] . '</option>';
        }
        echo '</select>';
    } else {
        echo "Não foi possível se autenticar no servidor LDAP.";
    }
} else {
    echo "Não foi possível conectar ao servidor LDAP.";
}


?>
