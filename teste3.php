<?php
$string = "CN=Grupo_RH,CN=Groups,DC=local,DC=lab";
$posicao_virgula = strpos($string, ','); // encontrar a posição da primeira vírgula
if ($posicao_virgula !== false) { // verificar se a vírgula foi encontrada
    $resultado = substr($string,0, $posicao_virgula); // extrair a parte antes da primeira vírgula
} else {
    $resultado = $string; // caso não tenha vírgula, retornar a string inteira
}
$resultadofinal = substr($resultado,3, $posicao_virgula);
echo $resultadofinal;
?>