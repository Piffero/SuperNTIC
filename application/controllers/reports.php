<?php
require_once ("secure_area.php");

class Reports extends Secure_area
{

	function __construct()
	{
		parent::__construct('reports');
	}

	function index()
	{
		date_default_timezone_set("America/Sao_Paulo");
		
		$l = $this->General->select2('patient_id, first_name, last_name', 'patient', NULL, 'first_name', 'asc')->result_array();
		$data['lista'] = '<option value="all">Tudo</option>
					<optgroup label="Clientes">';
		
		foreach ($l as $value)
		{
			$data['lista'] .= '<option value="cliente:' . $value['patient_id'] . '">' . $value['first_name'] . ' ' . $value['last_name'] . '</option>' . "\n";
		}
		
		// ###########################################
		
		$e = $this->General->select2("enterprise_id, fantasia", "enterprise")->result_array();
		$data['empresas'] = '';
		
		foreach ($e as $value)
		{
			$data['empresas'] .= '<option value="' . $value['enterprise_id'] . '">' . $value['fantasia'] . '</option>';
		}
		
		$this->load->view('reports/reports', $data);
	}

	function refer($refered)
	{
		switch ($refered)
		{
			case 'fornecedor':
				
				$l = $this->General->select2('suppliers_id, corporate_name, fancy_name', 'suppliers', NULL, 'fancy_name', 'asc')->result_array();
				$lista = '<option value="all">Tudo</option>
						<optgroup label="Fornecedores">';
				
				foreach ($l as $value)
				{
					$lista .= '<option value="fornecedor:' . $value['suppliers_id'] . '">' . $value['fancy_name'] . '</option>' . "\n";
				}
				
				break;
			
			case 'cliente':
				$l = $this->General->select2('patient_id, first_name, last_name', 'patient', NULL, 'first_name', 'asc')->result_array();
				$lista = '<optgroup label="Clientes">
							<option value="all">Tudo</option>';
				
				foreach ($l as $value)
				{
					$lista .= '<option value="cliente:' . $value['patient_id'] . '">' . $value['first_name'] . ' ' . $value['last_name'] . '</option>' . "\n";
				}
				
				break;
			
			case 'all':
			default:
				$lista = '<option value="all">Tudo</option>';
				echo $lista;
				exit();
				break;
		}
		
		$lista .= '</optgroup>';
		echo $lista;
	}

	function generate()
	{
		// Tipo do relatorio
		$tipo = explode(":", $this->input->post('tipo'));
		
		// Empresa na qual se baseará o relatório
		$enterprise = $this->input->post('enterprise');
		
		// Referência em ser: todos ou cliente ou fornecedores
		$refer = $this->input->post("refer");
		
		if ($refer == 'all') // tudo
		{
			$refer = array(2 => 'all');
		}
		else
		{
			$refer = explode(":", $this->input->post('refer'));
			//print_r($refer);
			
			// Começa setado como cliente
			$cons = $this->General->select2("first_name, last_name", "patient", array('patient_id' => $refer[1]))->row();
			
			$refer[2] = $cons->first_name . ' ' . $cons->last_name;
			
			// Verifica se é fornecedor e então se for seta como fornecedor
			if ($refer[0] == 'fornecedor')
			{
				$cons = $this->General->select2("fancy_name", "suppliers", array('suppliers_id' => $refer[1]))->row();
				$refer[2] = $cons->fancy_name;
			}
		}
		
		// Datas de Início e Fim para parametrizar o relatório
		$DInic = explode("/", $this->input->post('DInic'));
		$DI = $DInic[2] . '-' . $DInic[1] . '-' . $DInic[0];
		$DFim = explode("/", $this->input->post('DFim'));
		$DF = $DFim[2] . '-' . $DFim[1] . '-' . $DFim[0];
		
		// Modo do relatório: Sumário ou Gráfico
		$mode = $this->input->post('mode');
		
		/**
		 * OBS.: Quando os valores vierem "all" significa que é para listar TODOS daquela categoria,
		 * ex.: $enterprise='all' , então afirma que é para listar os resultados de todas as empresas;
		 * ex2.: $favored='all' , então afirma-se que é para listar todos os favorecidos/desfavorecidos das contas
		 *
		 * Functions do Model Report:
		 * # Contas (Pagar, receber, canceladas, Vendas):
		 * - function contas($ini, $fim, $favored="all", $operation=NULL, $historic='all', $del=NULL, $location='all')
		 */
		
		echo('<button onclick="printDiv(\'tabler\');" class="btn btn-default btn-flat pull-right"><i class="fa fa-print"></i></button>');
		
		// Verifica o tipo para qual o relatório será gerado: compras, vendas, OS, consultas, etc : $tipo[0]
		switch ($tipo[0])
		{
			# $l => Lista em <table> já pronta que foi criada com array de consulta do banco de dados
			case "contas":
			default:

				switch ($tipo[1])
				{
					case "receber":
					default:
						$l = $this->Report->contas($DI, $DF, $refer[2], 0, "all", 0, $enterprise);
						contas_table_report($l);
						break;
					
					case "pagar":
						$l = $this->Report->contas($DI, $DF, $refer[2], 1, "all", 0, $enterprise);
						contas_table_report($l);
						break;
					
					case "canceladas":
						$l = $this->Report->contas($DI, $DF, $refer[2], NULL, "all", 1, $enterprise);
						contas_table_report($l);
						break;
				}
				
				break;
			
			case "vendas":

				switch ($tipo[1])
				{
					case "efetuadas":
					default:
						$l = $this->Report->contas($DI, $DF, $refer[2], 0, "Venda de Mercadoria", 0, $enterprise);
						contas_table_report($l);
						break;
					
					case "canceladas":
						$l = $this->Report->contas($DI, $DF, $refer[2], 0, "Venda de Mercadoria", 1, $enterprise);
						contas_table_report($l);
						break;
				}
				
				break;
			
			case "itens":
				
				switch ($tipo[1])
				{
					case "vendidos":
					default:
						$l = $this->Report->itens($DI, $DF, $refer[2], $enterprise);
						itens_table_report($l);
						break;
						
					case "teste":
						$this->Report->teste($DI, $DF, $refer[2], $enterprise, "3");
						break;
					
					case "estoque": # Não Serializados
						$l = $this->Report->itens_estoque($DI, $DF, $refer[2], $enterprise, "1");
						estoque_itens_table_report($l);
						break;
						
					case "Sestoque": # Serializados
						$l = $this->Report->itens_estoque($DI, $DF, $refer[2], $enterprise, "1");
						estoque_itens_table_report($l);
						break;
				}
				
				break;
			
			case "compras":
				
				switch ($tipo[1])
				{
					case "efetuadas":
					default:
						$l = $this->Report->compras($DI, $DF, 0, $enterprise, $refer[2]);
						compras_table_report($l);
						break;
					
					case "canceladas":
						$l = $this->Report->compras($DI, $DF, 1, $enterprise, $refer[2]);
						compras_table_report($l);
						break;
				}
				
				break;
			
			case "os":
				
				switch ($tipo[1])
				{
					case "finalizadas":
					default:
						$l = $this->Report->os($DI, $DF, "Finalizada", $enterprise);
						//print_r($l);
						os_table_report($l, $tipo[1]);
						break;
					
					case "canceladas":
						$l = $this->Report->os($DI, $DF, "Cancelada", $enterprise);
						os_table_report($l, $tipo[1]);
						break;
					
					case "andamento":
						$l = $this->Report->os($DI, $DF, "Andamento", $enterprise);
						os_table_report($l, $tipo[1]);
						break;
						
					}
				
				break;
			
			case "consultas":
				
				switch ($tipo[1])
				{
					case "abertas":
					default:
						$l = $this->Report->consultas($DI, $DF, "consulta", 0);
						consultas_table_report($l);
						break;
					
					case "fechadas":
						$l = $this->Report->consultas($DI, $DF, "consulta", 1);
						consultas_table_report($l);
						break;
					
					case "acompab":
						$l = $this->Report->consultas($DI, $DF, "acompanhamento", 0);
						consultas_table_report($l);
						break;
				
					case "acompfec":
						$l = $this->Report->consultas($DI, $DF, "acompanhamento", 1);
						consultas_table_report($l);
						break;
				}
				
				break;
		}
	}
	
	function requestDate() 
	{
		echo date("d/m/Y H:i:s");
	}
}