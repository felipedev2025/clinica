<?php 
//definir fuso horário
date_default_timezone_set('America/Sao_Paulo');
//dados conexão bd local
$servidor = 'localhost';
$banco = 'clinica';
$usuario = 'root';
$senha = '';

$modo_teste = 'Não';

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8mb4", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro ao conectar ao banco de dados!<br>';
	echo $e;
}

// se a confirmação da mensagem do whatsapp não funcionar e seu servidor for https, coloque na linha abaixo o s para ficar https
$url_sistema = "https://$_SERVER[HTTP_HOST]/sistema/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/sistema/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/clinica/sistema/";
}

//variaveis globais
$nome_sistema = 'Nome Sistema';
$email_sistema = 'contato@hugocursos.com.br';
$telefone_sistema = '(31)97527-5084';
$query = $pdo->query("SELECT * from config");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas == 0){
	$pdo->query("INSERT INTO config SET nome = '$nome_sistema', email = '$email_sistema', telefone = '$telefone_sistema', logo = 'logo.png', logo_rel = 'logo.jpg', icone = 'icone.png', marca_dagua = 'Sim', ativo = 'Sim', paciente_receita = 'Sim', ocultar_acessos = 'Sim', desativar_marketing = 'Sim', agendamento_cliente = 'Sim', porc_servico = '0'");
}else{
$nome_sistema = $res[0]['nome'];
$email_sistema = $res[0]['email'];
$telefone_sistema = $res[0]['telefone'];
$endereco_sistema = $res[0]['endereco'];
$logo_sistema = $res[0]['logo'];
$logo_rel = $res[0]['logo_rel'];
$icone_sistema = $res[0]['icone'];
$telefone_fixo = $res[0]['telefone_fixo'];
$comissao_sistema = $res[0]['comissao'];
$token = $res[0]['token'];
$instancia = $res[0]['instancia'];
$horas_confirmacao = $res[0]['horas_confirmacao'];
$marca_dagua = $res[0]['marca_dagua'];
$ativo_sistema = $res[0]['ativo'];
$paciente_receita = $res[0]['paciente_receita'];
$ocultar_acessos = $res[0]['ocultar_acessos'];
$desativar_marketing = $res[0]['desativar_marketing'];
$seletor_api = $res[0]['seletor_api'];
$tempo_tela_chamadas = $res[0]['tempo_tela_chamadas'];
$tempo_tela_consultas = $res[0]['tempo_tela_consultas'];
$horas_confirmacaoF = $horas_confirmacao.':00:00';

$token_whatsapp = $res[0]['token'];
$instancia_whatsapp = $res[0]['instancia'];

$agendamento_cliente = $res[0]['agendamento_cliente'];
$mapa = $res[0]['mapa'];
$porc_servico = $res[0]['porc_servico'];
$fundo_login = $res[0]['fundo_login'];

$opcao_pagar = $res[0]['opcao_pagar'];
$municipio_sistema = $res[0]['municipio_sistema'];
$chave_teleconsulta = $res[0]['chave_teleconsulta'];

if($fundo_login == ""){
	$fundo_login = 'sem-foto.png';
}

if($ativo_sistema != 'Sim' and $ativo_sistema != ''){ ?>
	<style type="text/css">
		@media only screen and (max-width: 700px) {
		  .imgsistema_mobile{
		    width:300px;
		  }    
		}
	</style>
	<div style="text-align: center; margin-top: 100px">
	<img src="<?php echo $url_sistema ?>painel/images/bloqueio.png" class="imgsistema_mobile">	
	</div>
<?php 
exit();
} 
$whatsapp_sistema = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_sistema);
}	
 ?>