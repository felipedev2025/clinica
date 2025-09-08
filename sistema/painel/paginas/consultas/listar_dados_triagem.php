<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
require_once("../../../conexao.php");

$id = @$_POST['id_triagem'];


$query = $pdo->query("SELECT * from triagens where id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_paciente = $res[0]['id_paciente'];
$risco = $res[0]['risco'];
$queixa = $res[0]['queixa'];
$pa = $res[0]['pa'];
$fc = $res[0]['fc'];
$fr = $res[0]['fr'];
$temperatura = $res[0]['temperatura'];
$saturacao = $res[0]['saturacao'];
$alergias = $res[0]['alergias'];
$medicamentos = $res[0]['medicamentos'];
$historico = $res[0]['historico'];
$inicio_sintomas = $res[0]['inicio_sintomas'];
$condicao_geral = $res[0]['condicao_geral'];
$escala_dor = $res[0]['escala_dor'];
$data = $res[0]['data'];
$hora = $res[0]['hora'];


$query = $pdo->query("SELECT * FROM pacientes WHERE id = '$id_paciente' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$nome_pac = $res[0]['nome'];
$data_nasc_pac = $res[0]['data_nasc'];
$sexo_pac = $res[0]['sexo'];
$cpf_pac = $res[0]['cpf'];
$cartao_sus_pac = $res[0]['cartao_sus'];
$endereco_pac = $res[0]['endereco'];
$telefone_pac = $res[0]['telefone'];
$data_pac = $res[0]['data_cad'];
$hora_pac = $res[0]['hora_cad'];
$data_pacF = @implode('/', array_reverse(explode('-', $data_pac)));


echo '
<div style="font-family: Arial, sans-serif; font-size: 14px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">DADOS DO PACIENTE</h4>

    <p style="margin: 3px 0;">
        <strong>Nome Completo:</strong> '.$nome_pac.' 
        &nbsp;&nbsp;&nbsp; <strong>Data de Nascimento:</strong> '.implode("/", array_reverse(explode("-", $data_nasc_pac))).' 
        &nbsp;&nbsp;&nbsp; <strong>Sexo:</strong> '.(($sexo_pac == "Masculino") ? "<b>( X )</b> Masculino ( ) Feminino" : "( ) Masculino <b>( X )</b> Feminino").'
    </p>

    <p style="margin: 3px 0;">
        <strong>CPF:</strong> '.$cpf_pac.' 
        &nbsp;&nbsp;&nbsp; <strong>Cartão SUS:</strong> '.$cartao_sus_pac.'
    </p>

    <p style="margin: 3px 0;">
        <strong>Endereço:</strong> '.$endereco_pac.' 
        &nbsp;&nbsp;&nbsp; <strong>Telefone:</strong> '.$telefone_pac.'
    </p>

    <p style="margin: 3px 0;">
        <strong>Data:</strong> '.$data_pacF.' 
        &nbsp;&nbsp;&nbsp; <strong>Horário:</strong> '.$hora_pac.'
    </p>

</div>



<div style="font-family: Arial, sans-serif; font-size: 13px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">DADOS DO ATENDIMENTO</h4>

    <p style="margin: 3px 0;">
        <strong>Classificação de Risco:</strong><br>';

        $check_azul = ($risco == "Azul") ? "<b style=\"color:#2196F3;\">( X )</b>" : "( )";
        $check_verde = ($risco == "Verde") ? "<b style=\"color:#4CAF50;\">( X )</b>" : "( )";
        $check_amarelo = ($risco == "Amarelo") ? "<b style=\"color:#FFEB3B;\">( X )</b>" : "( )";
        $check_laranja = ($risco == "Laranja") ? "<b style=\"color:#FF9800;\">( X )</b>" : "( )";
        $check_vermelho = ($risco == "Vermelho") ? "<b style=\"color:#F44336;\">( X )</b>" : "( )";

echo '
        '.$check_vermelho.' Vermelho – Emergência &nbsp;&nbsp; 
        '.$check_laranja.' Laranja – Muita Urgência &nbsp;&nbsp; 
        '.$check_amarelo.' Amarelo – Urgência &nbsp;&nbsp; 
        '.$check_verde.' Verde – Pouca Urgência &nbsp;&nbsp; 
        '.$check_azul.' Azul – Não Urgente
    </p>

    <p style="margin: 3px 0;">
        <strong>Motivo da Procura / Queixa Principal:</strong><br>
        '.$queixa.'
    </p>

    <p style="margin: 3px 0; border-top:1px solid #000; margin-top: 10px"><br>
        <strong>Sinais Vitais:</strong><br>
        PA: '.$pa.' mmHg &nbsp;&nbsp; 
        FC: '.$fc.' bpm &nbsp;&nbsp; 
        FR: '.$fr.' irpm &nbsp;&nbsp; 
        Temperatura: '.$temperatura.' °C &nbsp;&nbsp; 
        Saturação: '.$saturacao.' %
    </p>

</div>';
