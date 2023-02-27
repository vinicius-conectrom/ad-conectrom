<?php
include 'ldap.php';

$usuario_habilitado = '(useraccountcontrol=512)(useraccountcontrol=66048)';
$usuario_desabilitado =  '(useraccountcontrol=514)(useraccountcontrol=66050)';


$filter = '(|'.$usuario_habilitado.')'; // filtro de objetos do ldap
$busca = ldap_search($ldapcon,$ldap_base_dn, $filter) or exit("Busca desativada"); // adicionando o filtro a busca
$entrada = ldap_get_entries($ldapcon, $busca); // pegando objetos da busca

echo "<div id='conteudohide'>";
global $nome_funcionario, $setor_funcionario;
for ($i=0; $i < $entrada["count"]; $i++) {
  $nome_funcionario = (isset($entrada[$i]["cn"][0]) ? $entrada[$i]["cn"][0]: 'Sem dados');
  $login_funcionario = (isset($entrada[$i]["samaccountname"][0]) ? $entrada[$i]["samaccountname"][0]: 'Sem dados');
  $email_funcionario = (isset($entrada[$i]["mail"][0]) ? $entrada[$i]["mail"][0]: 'Sem dados');
  $telefone_funcionario = (isset($entrada[$i]['telephonenumber'][0]) ? $entrada[$i]['telephonenumber'][0]: 'Sem dados');
  $setor_funcionario = (isset($entrada[$i]["department"][0]) ? $entrada[$i]["department"][0]: 'Sem dados');
  //$ativo_funcionario = (($entrada[$i]["useraccountcontrol"][0] == 512 || $entrada[$i]["useraccountcontrol"][0] == 66048) ? 'Habilitado': 'Desabilitado');
  $local_funcionario = (isset($entrada[$i]["physicaldeliveryofficename"][0]) ? $entrada[$i]["physicaldeliveryofficename"][0]: 'Sem dados');

    echo "<div class='dvConteudo'><tr>".
            "<td> ".$nome_funcionario."</td> ".
            "<td> ".$login_funcionario."</td> ".
            "<td> ".$email_funcionario."</td> ".
           "<td> ".$telefone_funcionario."</td> ".
            "<td> ".$setor_funcionario."</td> ".
            "<td> ".$local_funcionario."</td> ".
            "<td> 
            <div class='d-flex justify-content-between'>
            <form action='user-remove.php?nome=$nome_funcionario' method='POST'>
            <button type='submit' class='btn btn-danger'>Desabilitar</button>
            </form>
            <form action='' method=''>
            <button type='button' class='btn btn-secondary disabled ml-2' data-toggle='modal' data-target='#m-01'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
          </svg></button>
            </form>
            </div>
            </td></div>"
            ;
}
echo "</div>";

// (useraccountcontrol=514)(useraccountcontrol=66050) // usuários desabilitados
// (useraccountcontrol=512)(useraccountcontrol=66048) // usuários habilitados
// (objectCategory=person)(objectCategory=contact)
// (samaccountname=hadrielle.maria)(useraccountcontrol=66050)

#https://www.nvlan.com.br/comunidade/utilizando-o-atributo-useraccountcontrol/

// Valores convencionais:
// ===========================
// 512 - Enable Account
// 514 - Disable account
// 576 - Enable Account + Passwd_cant_change
// 544 - Account Enabled - Require user to change password at first logon
// 4096 - Workstation/server
// 66048 - Enabled, password never expires
// 66050 - Disabled, password never expires
// 262656 - Smart Card Logon Required
// 532480 - Domain controller

// Todos os valores:
// ===========================
// 1 - script
// 2 - accountdisable
// 8 - homedir_required
// 16 - lockout
// 32 - passwd_notreqd
// 64 - passwd_cant_change
// 128 - encrypted_text_pwd_allowed
// 256 - temp_duplicate_account
// 512 - normal_account
// 2048 - interdomain_trust_account
// 4096 - workstation_trust_account
// 8192 - server_trust_account
// 65536 - dont_expire_password
// 131072 - mns_logon_account
// 262144 - smartcard_required
// 524288 - trusted_for_delegation
// 1048576 - not_delegated
// 2097152 - use_des_key_only
// 4194304 - dont_req_preauth
// 8388608 - password_expired
// 16777216 - trusted_to_auth_for_delegation
