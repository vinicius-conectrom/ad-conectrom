<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Form de exemplo com checkboxes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark bg-primary">

        <a class="navbar-brand" href="#">SIS-CADASTRO</a>
    </nav>
    <div class="row">
        <br>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
            </div>

            <div class="col-11">
                <form class="form-row" action="cadastro.php" method="post">

                    <div class="form-group col-md-3 mb-3">
                        <label for="P_nome">Primeiro Nome</label>
                        <input id="p_nome" class="form-control" type="text" name="p-nome">
                    </div>
                    <div class="valid-tooltip">
                    </div>
                    <div class="form-group col-md-9 mb-3">
                        <label for="s_nome">Sobrenome</label>
                        <input id="s-nome" class="form-control" type="text" name="s-nome">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="login">Login</label>
                        <input id="login" class="form-control" type="text" name="login_rede">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="fone">Telefone</label>
                        <input id="fone" class="form-control" type="text" name="fone">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="func">Função</label>
                        <input id="func" class="form-control" type="text" name="funcao">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="l-trabalho">Local de Trabalho</label>
                        <select id="l-trabalho" class="custom-select" name="local_trabalho">
                            <option value="Cajuína - RN">Cajuína - RN</option>
                            <option value="UFV LUZIA - PB">UFV LUZIA - PB</option>
                            <option value="Serra do Seridó - PB">Serra do Seridó - PB</option>
                            <option value="Matriz">Matriz</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="l-trabalho">Setor</label>
                        <?php
                        include 'ldap.php';
                        $ldap_base_groups = 'OU=gruposlocal,DC=local,DC=lab';
                        if ($ldapcon) {
                            // Autenticação no servidor LDAP
                            $ldap_bind = ldap_bind($ldapcon, $user, $ldappass);
                            if ($ldap_bind) {
                                // Pesquisa por todos os grupos no diretório LDAP
                                $search_filter = '(objectClass=group)';
                                $result = ldap_search($ldapcon, $ldap_base_groups, $search_filter);
                                $entries = ldap_get_entries($ldapcon, $result);

                                // Imprime os grupos encontrados em uma tabela HTML
                                echo '<select id="l-trabalho" class="custom-select" name="grupo">';
                                for ($i = 0; $i < $entries['count']; $i++) {
                                    $valor = $entries[$i]['dn'];
                                    // echo $valor;
    
                                    // -------------teste
                                    $string = $valor;
                                    $posicao_virgula = strpos($string, ','); // encontrar a posição da primeira vírgula
                                    if ($posicao_virgula !== false) { // verificar se a vírgula foi encontrada
                                        $resultado = substr($string, 0, $posicao_virgula); // extrair a parte antes da primeira vírgula
                                    } else {
                                        $resultado = $string; // caso não tenha vírgula, retornar a string inteira
                                    }
                                    $resultadofinal = substr($resultado, 3, $posicao_virgula);
                                    // echo $resultadofinal;
    
                                    // --------------teste
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
                    </div>


                    <div class="btn-group" role="group" aria-label="Button group">
                        <button class="btn btn-primary" type="submit">Cadastro</button>
                    </div>
                </form>
            </div>
            <div class="col">

            </div>
        </div>
        <table id="cabecalho" class="table table-bordered table-striped my-4">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Setor</th>
                    <th>Local</th>
                    <th>Funções</th>
                </tr>

                <!------------------------------------ Modal de cadastro --------------------------------------->
                <div id="m-01" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Adicionar usuário ao grupo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <select name="seuSelect" class="form-control">
                                    <option value="opcao1">TI</option>
                                    <option value="opcao2">RH</option>
                                    <option value="opcao3">Finanças</option>
                                    <option value="opcao4">Almoxarifado</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="button" class="btn btn-primary">Salvar mudanças</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!------------------------------------ Fim do modal de cadastro --------------------------------------->

            <tbody>
                <?php include 'listauser.php' ?>
            </tbody>
        </table>
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>