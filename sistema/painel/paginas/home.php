<?php 

if(@$home == 'ocultar'){

	echo "<script>window.location='../index.php'</script>";

    exit();

}



$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
	$dia_final_mes = '30';
}else if($mes_atual == '2'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));	if($bissexto == 1){
		$dia_final_mes = $ano_atual.'-'.$mes_atual.'-29';	}else{
		$dia_final_mes = $ano_atual.'-'.$mes_atual.'-28';
	}
}else{
	$dia_final_mes = '31';
}
$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;



//totalizar pacientes

$query = $pdo->query("SELECT * from pacientes");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_pacientes = @count($res);



//pagar hoje

$total_pagar_hoje = 0;

$query = $pdo->query("SELECT * from pagar where data_venc = curDate() and pago != 'Sim'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$pagar_hoje = @count($res);

if($pagar_hoje > 0){

	for($i=0; $i < $pagar_hoje; $i++){

		$total_pagar_hoje += $res[$i]['valor'];

		$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');

	}

}





//receber hoje

$total_receber_hoje = 0;

$query = $pdo->query("SELECT * from receber where data_venc = curDate() and pago != 'Sim'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$receber_hoje = @count($res);

if($receber_hoje > 0){

	for($i=0; $i < $receber_hoje; $i++){

		$total_receber_hoje += $res[$i]['valor'];

		$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');

	}

}









//pagar_vencidas

$query = $pdo->query("SELECT * from pagar where data_venc < curDate() and pago != 'Sim'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$pagar_vencidas = @count($res);





//contas pagar mes

$query = $pdo->query("SELECT * from pagar where data_venc >= '$data_inicio_mes' and data_venc <= '$data_final_mes'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_pagar_mes = @count($res);



//contas pagas mes

$query = $pdo->query("SELECT * from pagar where data_venc >= '$data_inicio_mes' and data_venc <= '$data_final_mes' and pago = 'Sim'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_pagas_mes = @count($res);



//porcentagem

if($total_pagar_mes > 0 and $total_pagas_mes > 0){

    $porcentagem_pagar = ($total_pagas_mes / $total_pagar_mes) * 100;

}else{

    $porcentagem_pagar = 0;

}









//consultas hoje

$query = $pdo->query("SELECT * from agendamentos where data = curDate()");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$consultasHoje = @count($res);



//confirmadas hoje

$query = $pdo->query("SELECT * from agendamentos where status != 'Agendado' and data = curDate()");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$confirmadasHoje = @count($res);





//concluidas hoje

$query = $pdo->query("SELECT * from agendamentos where status = 'Finalizado' and data = curDate()");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$finalizadasHoje = @count($res);





//porcentagem

if($finalizadasHoje > 0 and $consultasHoje > 0){

    $porcentagem_consultas = ($finalizadasHoje / $consultasHoje) * 100;

}else{

    $porcentagem_consultas = 0;

}







//consultas mes

$query = $pdo->query("SELECT * from agendamentos where data >= '$data_inicio_mes' and data <= '$data_final_mes'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$consultasMes = @count($res);



//concluidas mes

$query = $pdo->query("SELECT * from agendamentos where status = 'Finalizado' and data >= '$data_inicio_mes' and data <= '$data_final_mes'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$finalizadasMes = @count($res);





//porcentagem mes

if($finalizadasMes > 0 and $consultasMes > 0){

    $porcentagem_consultas_mes = ($finalizadasMes / $consultasMes) * 100;

}else{

    $porcentagem_consultas_mes = 0;

}





// ==================== CÓDIGO CORRIGIDO E OTIMIZADO (PARA SUBSTITUIR) ====================

// 1. INICIALIZAÇÃO OBRIGATÓRIA DOS ARRAYS
// Isso garante que as variáveis sempre existam, evitando o erro "Undefined variable".
$labels_meses = [];
$valores_receber = [];
$valores_pagar = [];

// 2. LÓGICA DE CÁLCULO MAIS LIMPA E EFICIENTE
$meses = 6;
$data_base = date('Y-m-01'); // Pega o primeiro dia do mês atual
$data_inicio_apuracao = date('Y-m-d', @strtotime("-5 months", @strtotime($data_base))); // Calcula 5 meses para trás para ter um total de 6 pontos de dados

for ($cont = 0; $cont < $meses; $cont++) {
    // Calcula o mês e ano para cada iteração do loop
    $data_corrente = date('Y-m-d', @strtotime("+$cont months", @strtotime($data_inicio_apuracao)));
    
    // Pega o nome do mês em português diretamente com a função date, sem precisar de vários "if"s
    $mes_numero = date('m', @strtotime($data_corrente));
    $ano_numero = date('Y', @strtotime($data_corrente));
    
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese'); // Garante o locale para português
    $nome_mes = ucfirst(@strftime('%B', @strtotime($data_corrente))); // Converte para nome do mês (ex: "Junho")

    // Define o primeiro e o último dia daquele mês
    $primeiro_dia_mes = "$ano_numero-$mes_numero-01";
    $ultimo_dia_mes = date('Y-m-t', @strtotime($primeiro_dia_mes)); // 't' pega o último dia do mês automaticamente

    // Query para total de recebimentos (muito mais eficiente)
    $query_receber = $pdo->prepare("SELECT SUM(valor) as total FROM receber WHERE data_pgto BETWEEN :inicio AND :fim AND pago = 'Sim'");
    $query_receber->execute([':inicio' => $primeiro_dia_mes, ':fim' => $ultimo_dia_mes]);
    $total_receber = $query_receber->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Query para total de pagamentos (muito mais eficiente)
    $query_pagar = $pdo->prepare("SELECT SUM(valor) as total FROM pagar WHERE data_pgto BETWEEN :inicio AND :fim AND pago = 'Sim'");
    $query_pagar->execute([':inicio' => $primeiro_dia_mes, ':fim' => $ultimo_dia_mes]);
    $total_pagar = $query_pagar->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // 3. Adiciona os valores aos arrays que o gráfico usará
    $labels_meses[] = $nome_mes;
    $valores_receber[] = (float)$total_receber; // Converte para número
    $valores_pagar[] = (float)$total_pagar;   // Converte para número
}
// ============================= FIM DO BLOCO PARA SUBSTITUIR =============================

//valores para grafico de barras
// ==================== CÓDIGO FINAL E COMPLETO PARA O GRÁFICO DE BARRAS ====================

// 1. INICIALIZAÇÃO DA VARIÁVEL (A LINHA QUE ESTAVA FALTANDO)
$total_meses = '';

// 2. LOOP OTIMIZADO PARA BUSCAR OS DADOS
//valores para grafico de barras
for($cont=1; $cont<=12; $cont++){
    
    // Lógica para formatar o mês com zero à esquerda
    $mes = str_pad($cont, 2, '0', STR_PAD_LEFT);
    
    // Lógica para pegar o primeiro e último dia do mês
    $data_inicio_mes_barra = $ano_atual.'-'.$mes.'-01';
    $data_fim_mes_barra = date('Y-m-t', @strtotime($data_inicio_mes_barra));

    // Consulta Otimizada
    $query = $pdo->prepare("SELECT COUNT(*) as total FROM agendamentos WHERE data BETWEEN :inicio AND :fim AND status = 'Finalizado'");
    $query->execute([':inicio' => $data_inicio_mes_barra, ':fim' => $data_fim_mes_barra]);
    $total_mes = $query->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

    // Concatena o resultado na string
    $total_meses .= $total_mes.'*';
}
// ==================================== FIM DO BLOCO ====================================
 ?>





<?php if($ativo_sistema == ''){ ?>

<div style="background: #f7ff1c; color:#3e3e3e; padding:10px; font-size:14px; margin-bottom:10px">

<div><i class="fa fa-info-circle"></i> <b>Aviso: </b> Prezado Cliente, não identificamos o pagamento de sua última mensalidade, entre em contato conosco o mais rápido possivel para regularizar o pagamento, caso contário seu acesso ao sistema será desativado.</div>

</div>

<?php } ?>



<!-- Campo para alterar ; WHITELABEL-->

<div class="main-page">
    
    <div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: flex-start; margin: 0 -8px;">

    <a href="pacientes" style="flex: 1 1 200px; min-width: 200px; background-color: #07378a; color: #ffffff; border-radius: 8px; padding: 16px; margin: 8px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center;">
            <div style="margin-right: 16px;"><i class="fa fa-users" style="font-size: 32px;"></i></div>
            <div>
                <div style="font-size: 22px; font-weight: 700;"><?php echo $total_pacientes ?></div>
                <div style="font-size: 14px; opacity: 0.8;">Total Pacientes</div>
            </div>
        </div>
    </a>

    <a href="pagar" style="flex: 1 1 200px; min-width: 200px; background-color: #dc3545; color: #ffffff; border-radius: 8px; padding: 16px; margin: 8px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center;">
            <div style="margin-right: 16px;"><i class="fa fa-money" style="font-size: 32px;"></i></div>
            <div>
                <div style="font-size: 18px; font-weight: 700;">R$ <?php echo number_format($total_pagar_hoje, 2, ',', '.') ?></div>
                <div style="font-size: 14px; opacity: 0.8;">(<?php echo $pagar_hoje ?>) Pagar Hoje</div>
            </div>
        </div>
    </a>

    <a href="receber" style="flex: 1 1 200px; min-width: 200px; background-color: #198754; color: #ffffff; border-radius: 8px; padding: 16px; margin: 8px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center;">
            <div style="margin-right: 16px;"><i class="fa fa-money" style="font-size: 32px;"></i></div>
            <div>
                <div style="font-size: 18px; font-weight: 700;">R$ <?php echo number_format($total_receber_hoje, 2, ',', '.') ?></div>
                <div style="font-size: 14px; opacity: 0.8;">(<?php echo $receber_hoje ?>) Receber Hoje</div>
            </div>
        </div>
    </a>

    <a href="agendamentos" style="flex: 1 1 200px; min-width: 200px; background-color: #0dcaf0; color: #ffffff; border-radius: 8px; padding: 16px; margin: 8px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center;">
            <div style="margin-right: 16px;"><i class="fa fa-stethoscope" style="font-size: 32px;"></i></div>
            <div>
                <div style="font-size: 22px; font-weight: 700;"><?php echo $consultasHoje ?></div>
                <div style="font-size: 14px; opacity: 0.8;">Agenda Hoje</div>
            </div>
        </div>
    </a>

    <a href="agendamentos" style="flex: 1 1 200px; min-width: 200px; background-color: #6c757d; color: #ffffff; border-radius: 8px; padding: 16px; margin: 8px; text-decoration: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items-center;">
            <div style="margin-right: 16px;"><i class="fa fa-check" style="font-size: 32px;"></i></div>
            <div>
                <div style="font-size: 22px; font-weight: 700;"><?php echo $confirmadasHoje ?></div>
                <div style="font-size: 14px; opacity: 0.8;">Confirmadas</div>
            </div>
        </div>
    </a>

</div>



<!-- Campo para alterar ; WHITELABEL-->

	<div class="graficos-container" style="display: flex; flex-wrap: wrap; margin: 20px -8px 0 -8px;">

    <div class="coluna-grafico-principal" style="flex: 1 1 60%; min-width: 300px; padding: 8px;">
        <div class="card-grafico" style="background-color: #ffffff; border-radius: 8px; padding: 24px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); height: 100%;">
            <h5 style="margin: 0 0 20px 0; font-size: 18px; color: #343a40;">Entradas / Saídas</h5>
            <div style="position: relative; height: 300px;">
                <canvas id="graficoLinhasModerno"></canvas>
            </div>
        </div>
    </div>

    <div class="coluna-indicadores" style="flex: 1 1 35%; min-width: 250px; padding: 8px;">

    <div class="card-indicador" style="background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); margin-bottom: 16px; transition: all 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.05)';">
        <div style="display: flex; align-items: center; color: #6c757d; font-size: 14px; margin-bottom: 16px;">
            <i class="fa fa-calendar-check-o" style="margin-right: 8px; font-size: 16px; color: #28a745;"></i>
            <span>Consultas Hoje</span>
        </div>
        <div style="font-size: 32px; font-weight: 700; color: #212529; text-align: center; margin-bottom: 16px;">
            <span style="color: #28a745;"><?php echo $finalizadasHoje ?></span> / <span style="font-size: 24px; color: #6c757d;"><?php echo $consultasHoje ?></span>
        </div>
        <div class="progress-track" style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
            <div class="progress-bar" style="height: 100%; width: <?php echo $porcentagem_consultas ?>%; background-color: #28a745; border-radius: 4px; transition: width 0.5s ease-in-out;"></div>
        </div>
    </div>

    <div class="card-indicador" style="background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); margin-bottom: 16px; transition: all 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.05)';">
        <div style="display: flex; align-items: center; color: #6c757d; font-size: 14px; margin-bottom: 16px;">
            <i class="fa fa-calendar" style="margin-right: 8px; font-size: 16px; color: #0d6efd;"></i>
            <span>Consultas Mês</span>
        </div>
        <div style="font-size: 32px; font-weight: 700; color: #212529; text-align: center; margin-bottom: 16px;">
            <span style="color: #0d6efd;"><?php echo $finalizadasMes ?></span> / <span style="font-size: 24px; color: #6c757d;"><?php echo $consultasMes ?></span>
        </div>
        <div class="progress-track" style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
            <div class="progress-bar" style="height: 100%; width: <?php echo $porcentagem_consultas_mes ?>%; background-color: #0d6efd; border-radius: 4px; transition: width 0.5s ease-in-out;"></div>
        </div>
    </div>
    
    <div class="card-indicador" style="background-color: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); transition: all 0.2s ease-in-out;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.05)';">
        <div style="display: flex; align-items: center; color: #6c757d; font-size: 14px; margin-bottom: 16px;">
            <i class="fa fa-credit-card" style="margin-right: 8px; font-size: 16px; color: #dc3545;"></i>
            <span>Pagamentos Mês</span>
        </div>
        <div style="font-size: 32px; font-weight: 700; color: #212529; text-align: center; margin-bottom: 16px;">
            <span style="color: #dc3545;"><?php echo $total_pagas_mes ?></span> / <span style="font-size: 24px; color: #6c757d;"><?php echo $total_pagar_mes ?></span>
        </div>
        <div class="progress-track" style="height: 8px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
            <div class="progress-bar" style="height: 100%; width: <?php echo $porcentagem_pagar ?>%; background-color: #dc3545; border-radius: 4px; transition: width 0.5s ease-in-out;"></div>
        </div>
    </div>

</div>
	

	

	<div class="grafico-barras-linha" style="display: flex; width: 100%; padding: 0 8px 8px 8px;">

    <div class="card-grafico" style="width: 100%; background-color: #ffffff; border-radius: 8px; padding: 24px; box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
        
        <h5 style="margin: 0 0 20px 0; font-size: 18px; color: #343a40;">
            <i class="fa fa-bar-chart" style="color: #0d6efd; margin-right: 8px;"></i>
            Consultas Finalizadas <?php echo $ano_atual ?>
        </h5>
        
        <div style="position: relative; height: 350px;">
            <canvas id="graficoBarrasConsultas"></canvas>
        </div>

    </div>
</div>



	

</div>









<!-- for index page weekly sales java script -->

<script src="js/SimpleChart.js"></script>

<script>



	var meses = "<?=$datas_apuracao_final?>";

	var dados = meses.split("*"); 



	var receber = "<?=$total_receber_final?>";

	var dados_receber = receber.split("*"); 



	var pagar = "<?=$total_pagar_final?>";

	var dados_pagar = pagar.split("*"); 



		var maior_valor_linha_pagar = Math.max(...dados_pagar);

    	var maior_valor_linha_receber = Math.max(...dados_receber);

    	var maior_valor = Math.max(maior_valor_linha_pagar, maior_valor_linha_receber);

    	maior_valor = parseFloat(maior_valor) + 200;

    	

    	var menor_valor_linha_pagar = Math.min(...dados_pagar);

    	var menor_valor_linha_receber = Math.min(...dados_receber);

    	var menor_valor = Math.min(menor_valor_linha_pagar, menor_valor_linha_receber);



	var graphdata1 = {

		linecolor: "#c91508",

		title: "Despesas",

		values: [

		{ X: dados[0], Y: dados_pagar[0] },

		{ X: dados[1], Y: dados_pagar[1] },

		{ X: dados[2], Y: dados_pagar[2] },

		{ X: dados[3], Y: dados_pagar[3] },

		{ X: dados[4], Y: dados_pagar[4] },

		{ X: dados[5], Y: dados_pagar[5] },

		

		]

	};

	var graphdata2 = {

		linecolor: "#00CC66",

		title: "Recebimentos",

		values: [

		{ X: dados[0], Y: dados_receber[0] },

		{ X: dados[1], Y: dados_receber[1] },

		{ X: dados[2], Y: dados_receber[2] },

		{ X: dados[3], Y: dados_receber[3] },

		{ X: dados[4], Y: dados_receber[4] },

		{ X: dados[5], Y: dados_receber[5] },

		]

	};



	var dataRangeLinha = {

    		linecolor: "transparent",

    		title: "",

    		values: [

    		{ X: dados[0], Y: menor_valor },

    		{ X: dados[1], Y: menor_valor },

    		{ X: dados[2], Y: menor_valor },

    		{ X: dados[3], Y: menor_valor },

    		{ X: dados[4], Y: menor_valor },

    		{ X: dados[5], Y: maior_valor },

    		

    		]

    	};

	

		

		$("#Linegraph").SimpleChart({

			ChartType: "Line",

			toolwidth: "50",

			toolheight: "25",

			axiscolor: "#225ca3",

			textcolor: "#6E6E6E",

			showlegends: true,

			data: [graphdata2, graphdata1, dataRangeLinha],

			legendsize: "30",

			legendposition: 'bottom',

			xaxislabel: 'Meses',

    		title: 'Últimos 6 Meses',

    		yaxislabel: 'Total de Contas R$',

    		responsive: true,

		});

	



</script>

<!-- //for index page weekly sales java script -->







<!-- GRAFICO DE BARRAS -->

	<script type="text/javascript">

		$(document).ready(function() {



			var consultas = "<?=$total_meses?>";

			var dados = consultas.split("*");  



		   

				var color = Chart.helpers.color;

				var barChartData = {

					labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],

					datasets: [{

						label: '',

						backgroundColor: color('blue').alpha(0.5).rgbString(),

						borderColor: 'blue',

						borderWidth: 1,

						data: [

						dados[0],

						dados[1],

						dados[2],

						dados[3],

						dados[4],

						dados[5],

						dados[6],

						dados[7],

						dados[8],

						dados[9],

						dados[10],

						dados[11]

						

						]

					}, 

					]



				};



			var ctx = document.getElementById("canvas").getContext("2d");

					window.myBar = new Chart(ctx, {

						type: 'bar',

						data: barChartData,

						options: {

							responsive: true,

							legend: {

								position: '',

							},

							title: {

								display: true,

								text: 'Consultas Efetuadas nos Mêses'

							}

						}

					});



	})

	

	</script>
	<script>
document.addEventListener("DOMContentLoaded", function() {
    console.log("Iniciando script de gráfico de teste..."); // Mensagem para vermos no console

    try {
        // DADOS DE TESTE FIXOS (sem PHP)
        const labels = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho"];
        const dadosReceber = [0, 550, 0, 320, 0, 0];
        const dadosPagar = [0, 0, 0, 0, 0, 0];

        const ctx = document.getElementById('graficoLinhasModerno').getContext('2d');
        console.log("Canvas 'graficoLinhasModerno' encontrado."); // Outra mensagem de diagnóstico

        // Gradientes (código mantido)
        const gradientReceber = ctx.createLinearGradient(0, 0, 0, 300);
        gradientReceber.addColorStop(0, 'rgba(0, 204, 102, 0.3)');
        gradientReceber.addColorStop(1, 'rgba(0, 204, 102, 0)');

        const gradientPagar = ctx.createLinearGradient(0, 0, 0, 300);
        gradientPagar.addColorStop(0, 'rgba(220, 53, 69, 0.3)');
        gradientPagar.addColorStop(1, 'rgba(220, 53, 69, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                {
                    label: 'Recebimentos',
                    data: dadosReceber,
                    borderColor: '#00CC66',
                    backgroundColor: gradientReceber,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#00CC66',
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                },
                {
                    label: 'Despesas',
                    data: dadosPagar,
                    borderColor: '#dc3545',
                    backgroundColor: gradientPagar,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#dc3545',
                    pointHoverRadius: 7,
                    pointHoverBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: { // Opções de estilo mantidas
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#6c757d', usePointStyle: true, boxWidth: 8 }},
                    tooltip: {
                        backgroundColor: '#212529',
                        titleFont: { size: 14 }, bodyFont: { size: 12 }, padding: 10,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        border: { display: false },
                        grid: { color: '#f0f0f0', drawTicks: false },
                        ticks: { color: '#6c757d', padding: 10, callback: function(value) { return 'R$' + value; }}
                    },
                    x: {
                        border: { display: false },
                        grid: { display: false },
                        ticks: { color: '#6c757d', padding: 10 }
                    }
                }
            }
        });
        console.log("Gráfico de teste renderizado com sucesso!");
    } catch (error) {
        console.error("Ocorreu um erro ao tentar renderizar o gráfico:", error);
    }
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Pega os dados da variável PHP que já existia para este gráfico
    const consultasString = "<?php echo $total_meses; ?>";
    const dadosConsultas = consultasString.split('*').slice(0, 12); // Pega os 12 valores

    // Pega o contexto do NOVO canvas que criamos
    const ctx = document.getElementById('graficoBarrasConsultas').getContext('2d');

    // Cria um gradiente azul para as barras
    const gradient = ctx.createLinearGradient(0, 0, 0, 350);
    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.7)'); // Azul mais forte em cima
    gradient.addColorStop(1, 'rgba(13, 110, 253, 0.1)'); // Azul mais fraco embaixo

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            datasets: [{
                label: 'Consultas Finalizadas',
                data: dadosConsultas,
                backgroundColor: gradient, // Aplica o gradiente
                borderColor: 'rgba(13, 110, 253, 1)',
                borderWidth: 1,
                borderRadius: 5, // Arredonda o topo das barras
                hoverBackgroundColor: 'rgba(13, 110, 253, 0.9)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // Não precisa de legenda para um único dado
                },
                tooltip: {
                    backgroundColor: '#212529',
                    titleFont: { size: 14 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    callbacks: {
                        label: function(context) {
                            return `Consultas: ${context.parsed.y}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: {
                        display: false // Remove a linha do eixo Y
                    },
                    grid: {
                        color: '#f0f0f0', // Cor das linhas de grade horizontais
                    },
                    ticks: {
                        color: '#6c757d' // Cor dos números do eixo Y
                    }
                },
                x: {
                    grid: {
                        display: false // Remove as linhas de grade verticais
                    },
                    ticks: {
                        color: '#6c757d' // Cor dos meses no eixo X
                    }
                }
            }
        }
    });
});
</script>
	