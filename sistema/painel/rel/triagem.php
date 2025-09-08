<?php 
include('data_formatada.php');

if ($token_rel != 'DER47005') {
	echo '<script>window.location="../../"</script>';
	exit();
}

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
$hiposteses = $res[0]['hiposteses'];
$procedimentos_realizados = $res[0]['procedimentos_realizados'];
$conduta_medica = $res[0]['conduta_medica'];
$internacao = $res[0]['internacao'];
$aih = $res[0]['aih'];
$cid_10 = $res[0]['cid_10'];
$motivo_internacao = $res[0]['motivo_internacao'];
$justificativa_clinica = $res[0]['justificativa_clinica'];


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

?>
<!DOCTYPE html>
<html>
<head>

<style>

@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');
@page { margin: 145px 20px 25px 20px; }
#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }
#content {margin-top: 0px;}
#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }
#footer .page:after {content: counter(page, my-sec-counter);}
body {font-family: 'Tw Cen MT', sans-serif;}

.marca{
	position:fixed;
	left:50;
	top:100;
	width:80%;
	opacity:8%;
}

</style>

</head>
<body>
<?php 
if($marca_dagua == 'Sim'){ ?>
<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	
<?php } ?>


<div id="header" >

	<div style="border-style: solid; font-size: 10px; height: 50px;">
		<table style="width: 100%; border: 0px solid #ccc;">
			<tr>
				<td style="border: 1px; solid #000; width: 7%; text-align: left;">
					<img style="margin-top: 0px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="120px">
				</td>
				<td style="width: 33%; text-align: left; font-size: 13px;">
					
				</td>
				<td style="width: 5%; text-align: center; font-size: 13px;">
				
				</td>
				<td style="width: 40%; text-align: right; font-size: 9px;padding-right: 10px;">
						<b><big>DETALHAMENTO DA TRIAGEM</big></b><br>  <br> <?php echo mb_strtoupper($data_hoje) ?>
				</td>
			</tr>		
		</table>
	</div>

<br>


		
</div>

<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?> / Este documento é confidencial!</td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>

<div id="content" style="margin-top: -45px;">

<p align="center" style="font-size: 13px"><b>FICHA DE ATENDIMENTO DE URGÊNCIA E EMERGÊNCIA</b></p>

<div style="font-family: Arial, sans-serif; font-size: 10px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">DADOS DO PACIENTE</h4>

    <p style="margin: 3px 0;">
        <strong>Nome Completo:</strong> <?= $nome_pac ?> 
        &nbsp;&nbsp;&nbsp; <strong>Data de Nascimento:</strong> <?= implode('/', array_reverse(explode('-', $data_nasc_pac))) ?> 
        &nbsp;&nbsp;&nbsp; <strong>Sexo:</strong> <?= ($sexo_pac == 'Masculino') ? '<b>( X )</b> Masculino ( ) Feminino' : '( ) Masculino <b>( X )</b> Feminino' ?><b>
    </p>

    <p style="margin: 3px 0;">
        <strong>CPF:</strong> <?= $cpf_pac ?> 
        &nbsp;&nbsp;&nbsp; <strong>Cartão SUS:</strong> <?= $cartao_sus_pac ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Endereço:</strong> <?= $endereco_pac ?> 
        &nbsp;&nbsp;&nbsp; <strong>Telefone:</strong> <?= $telefone_pac ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Município:</strong> <?php echo $municipio_sistema ?>
        &nbsp;&nbsp;&nbsp;<strong>Data:</strong> <?php echo $data_pacF ?>
        &nbsp;&nbsp;&nbsp; <strong>Horário:</strong> <?php echo $hora_pac ?>
    </p>

</div>




<div style="font-family: Arial, sans-serif; font-size: 10px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">DADOS DO ATENDIMENTO</h4>

    <p style="margin: 3px 0;">
        <strong>Classificação de Risco:</strong>
        <?php
		    $check_azul = ($risco == 'Azul') ? '<b style="color:#2196F3;">( X )</b>' : '( )';
		    $check_verde = ($risco == 'Verde') ? '<b style="color:#4CAF50;">( X )</b>' : '( )';
		    $check_amarelo = ($risco == 'Amarelo') ? '<b style="color:#FFEB3B;">( X )</b>' : '( )';
		    $check_laranja = ($risco == 'Laranja') ? '<b style="color:#FF9800;">( X )</b>' : '( )';
		    $check_vermelho = ($risco == 'Vermelho') ? '<b style="color:#F44336;">( X )</b>' : '( )';
		?>
        <?= "$check_vermelho Vermelho – Emergência &nbsp;&nbsp; $check_laranja Laranja – Muita Urgência &nbsp;&nbsp; $check_amarelo Amarelo – Urgência &nbsp;&nbsp; $check_verde Verde – Pouca Urgência &nbsp;&nbsp; $check_azul Azul – Não Urgente" ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Motivo da Procura / Queixa Principal:</strong> <br>
        <?= $queixa ?>
    </p>


    <p style="margin: 3px 0; border-top:1px solid #000; margin-top: 10px"><br>
        <strong>Sinais Vitais:</strong><br>
        PA: <?= $pa ?> mmHg &nbsp;&nbsp; 
        FC: <?= $fc ?> bpm &nbsp;&nbsp; 
        FR: <?= $fr ?> irpm &nbsp;&nbsp; 
        Temperatura: <?= $temperatura ?> °C &nbsp;&nbsp; 
        Saturação: <?= $saturacao ?> %
    </p>

</div>




<div style="font-family: Arial, sans-serif; font-size: 10px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">AVALIAÇÃO MÉDICA INICIAL</h4>

    <p style="margin: 3px 0;">
        <strong>Hipóteses Diagnósticas / CID-10:</strong><br>
        <?= nl2br(@htmlspecialchars($hiposteses)) ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Procedimentos Realizados:</strong><br>
        <?php
            // Variável com texto dos procedimentos realizados (ex: "Sutura, Medicação, Curativo, Outros")
            $proc = @strtolower($procedimentos_realizados); // facilita comparação

            function checkProc($nomeProc, $procText) {
                return strpos($procText, @strtolower($nomeProc)) !== false ? '<b>( X )</b>' : '( )';
            }

            $sutura = checkProc('sutura', $proc);
            $medicacao = checkProc('medicação', $proc);
            $curativo = checkProc('curativo', $proc);
            $exames_lab = checkProc('exames laboratoriais', $proc);
            $exames_img = checkProc('exames de imagem', $proc);

            // Para "Outros", se tiver algum texto diferente destes
            $outros = '';
            $procedimentos_base = ['sutura', 'medicação', 'curativo', 'exames laboratoriais', 'exames de imagem'];
            foreach ($procedimentos_base as $baseProc) {
                $proc = str_ireplace($baseProc, '', $proc);
            }
            $outros = trim($proc);
        ?>

        <?= "$sutura Sutura &nbsp;&nbsp; $medicacao Medicação &nbsp;&nbsp; $curativo Curativo &nbsp;&nbsp; $exames_lab Exames laboratoriais &nbsp;&nbsp; $exames_img Exames de imagem" ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Outros:</strong> <?= nl2br(@htmlspecialchars($outros)) ?>
    </p>

    

</div>




<div style="font-family: Arial, sans-serif; font-size: 10px; border: 1px solid #000; padding: 8px; width: 98%; margin-bottom: 10px;">

    <h4 style="margin-bottom: 8px;">CONDUTA MÉDICA</h4>

    <p style="margin: 3px 0;">
        <?php
            $condAlta = ($conduta_medica == 'Alta Médica') ? '<b>( X )</b>' : '( )';
            $condEncaminhamento = ($conduta_medica == 'Encaminhamento Ambulatorial') ? '<b>( X )</b>' : '( )';
            $condObservacao = ($conduta_medica == 'Observação') ? '<b>( X )</b>' : '( )';

            $internacaoSim = ($internacao == 'Sim') ? '<b>( X )</b>' : '( )';
            $internacaoNao = ($internacao == 'Não') ? '<b>( X )</b>' : '( )';

            $aihSim = ($aih == 'Sim') ? '<b>( X )</b>' : '( )';
            $aihNao = ($aih == 'Não') ? '<b>( X )</b>' : '( )';
        ?>

       
        <?= "$condAlta Alta médica &nbsp;&nbsp; $condEncaminhamento Encaminhamento ambulatorial &nbsp;&nbsp; $condObservacao Observação" ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Internação:</strong> <?= "$internacaoSim Sim &nbsp;&nbsp; $internacaoNao Não" ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>Motivo da internação:</strong> <?= nl2br(@htmlspecialchars($motivo_internacao)) ?> <br>
        <strong>Justificativa clínica:</strong> <?= nl2br(@htmlspecialchars($justificativa_clinica)) ?>
    </p>

    <p style="margin: 3px 0;">
        <strong>CID-10 para internação:</strong> <?= @htmlspecialchars($cid_10) ?> &nbsp;&nbsp;
        <strong>Necessita AIH?</strong> <?= "$aihSim Sim &nbsp;&nbsp; $aihNao Não" ?>
    </p>
    <br>
    <p style="margin: 3px 0;">
        <strong>Data:</strong> ___ / ___ / _____ &nbsp;&nbsp; <strong>Horário:</strong> ___ : ___
    </p>

</div>




<table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 10px; margin-top: 20px;">
  <tr>
    <td style="border: 1px solid #000; padding: 8px; width: 50%; vertical-align: top; font-weight: bold; text-align: center;">

      Médico Responsável
    </td>
    <td style="border: 1px solid #000; padding: 8px; width: 50%; vertical-align: top; font-weight: bold; text-align: center;">
      Paciente ou Responsável
    </td>
  </tr>
  <tr>
    <td style="border: 1px solid #000; padding: 40px 8px 8px 8px; width: 50%; vertical-align: top; text-align: center;">
    	__________________________________________________________
      Carimbo
    </td>
    <td style="border: 1px solid #000; padding: 40px 8px 8px 8px; width: 50%; vertical-align: top; text-align: center;">
    	__________________________________________________________
      <!-- Espaço em branco para assinatura do paciente ou responsável -->
    </td>
  </tr>
</table>



</div>

</body>

</html>


