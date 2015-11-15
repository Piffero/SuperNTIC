<?php
require_once ("secure_area.php");

class Enterprises extends Secure_area
{

    function __construct()
    {
        parent::__construct('settings');
    }

    function index()
    {
        $this->company();
    }

    /**
     * QUADRO DE PERMISSOES *
     */
    function company($manager_result = null)
    {
        $data['listaEmpresa'] = $this->listaEmpresas();
        $data['manager_result'] = $manager_result;
        $this->load->view("settings/enterprise", $data);
    }

    function listaEmpresas()
    {
        $Enterprise = $this->Enterprise->get_all();
        $listaEmpresa = '';
        
        if ($Enterprise->num_rows() > 0) {
            foreach ($Enterprise->result() as $getEnterprise) {
                $listaEmpresa .= '<li><a href="' . site_url('enterprises/select_enterprise') . '/' . $getEnterprise->enterprise_id . '"><i class="fa fa-building-o"></i> ' . $getEnterprise->fantasia . '</a></li>';
            }
        }
        
        return $listaEmpresa;
        /*
         * <li><a href=""><i class="fa fa-building-o"></i> Empresa</a></li>
         * <li><a href=""><i class="fa fa-building-o"></i> Empresa</a></li>
         */
    }

    function select_enterprise($enterprise_id)
    {
        $data['enterprise_info'] = $this->Enterprise->get_info($enterprise_id);
        $data['listaEmpresa'] = $this->listaEmpresas();
        
        $this->load->view('settings/enterprise', $data);
    }

    function save($enterprise_id = -1)
    {
        $data_enterprise = array(
            'razaosocial' => $this->input->post('razaosocial'),
            'fantasia' => $this->input->post('fantasia'),
            'cnpj' => $this->input->post('cnpj'),
            'ie' => $this->input->post('ie'),
            'cnae_fiscal' => $this->input->post('cnae_fiscal'),
            'imunic' => $this->input->post('imunic'),
            'iest' => $this->input->post('iest'),
            'regimetributario' => $this->input->post('regimetributario'),
            'logradouro' => $this->input->post('logradouro'),
            'complemento' => $this->input->post('complemento'),
            'numero' => $this->input->post('numero'),
            'bairro' => $this->input->post('bairro'),
            'municipio' => $this->input->post('municipio'),
            'cMun' => $this->input->post('cMun'),
            'uf' => $this->input->post('uf'),
            'pais' => $this->input->post('pais'),
            'cPais' => $this->input->post('cPais'),
            'cep' => $this->input->post('cep'),
            'fone' => $this->input->post('fone')
        );
        
        if ($this->Enterprise->save($data_enterprise, $enterprise_id)) {
            if ($enterprise_id = - 1) {
                // mensagem sucesso insert
                $this->company('<div class="alert alert-success">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
									<i class="fa fa-check sign"></i>
									<strong>Sucesso! </strong>Empresa inserida com sucesso.
								</div>');
            } else {
                // mensagem sucesso update
                $this->company('<div class="alert alert-success">
									<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
									<i class="fa fa-check sign"></i>
									<strong>Sucesso! </strong>Empresa atualizada com sucesso.
								</div>');
            }
        } else {
            // mensagem fall
            $this->company('<div class="alert alert-danger">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-times sing"></i>
								<strong>Opss! </strong>Ocorreu um erro ao inserir a Empresa.
							</div>');
        }
    }

    function uploader_file($enterprise_id = -1)
    {
        $uploaddir = '/var/www/html/upload/';
        $uploadfile = $uploaddir . basename($_FILES['foto_logo']['name']);
        
        $data_enterprise = array(
            'logo_address' => $_FILES['foto_logo']['name']
        );
        
        if (move_uploaded_file($_FILES['foto_logo']['tmp_name'], $uploadfile)) {
            
            if ($enterprise_id != - 1) {
                if ($this->Enterprise->save($data_enterprise, $enterprise_id)) {
                    // mensagem sucesso update
                    $this->company('<div class="alert alert-success">
										<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
										<i class="fa fa-check sign"></i>
										<strong>Sucesso! </strong>Logo inserida com sucesso.
									</div>');
                } else {
                    // mensagem fall
                    $this->company('<div class="alert alert-danger">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-times sing"></i>
								<strong>Opss! </strong>Ocorreu um erro ao inserir a Empresa.
							</div>');
                }
            } else {
                // mensagem fall
                $this->company('<div class="alert alert-danger">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-times sing"></i>
								<strong>Opss! </strong>Você não pode inserir uma imagem antes de salvar as informações sobre a empresa.
							</div>');
            }
        } else {
            // mensagem fall
            $this->company('<div class="alert alert-danger">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">x</button>
								<i class="fa fa-times sing"></i>
								<strong>Opss! </strong>Ocorreu um erro ao enviar a logo.
							</div>');
        }
    }

    function export_emitente($enterprise_id = -1)
    {
        
        // Receberá todos os dados do banco para o XML
        $emit = $this->Enterprise->get_info($enterprise_id);
        
        // A raiz do meu documento XML
        $xml = '<sistema versao="1.02" xmlns="http://www.portalfiscal.inf.br/nfe">';
        $xml .= '<emit>';
        $xml .= '<CNPJ>' . $emit->cnpj . '</CNPJ>';
        $xml .= '<xNome>' . $emit->razaosocial . '</xNome>';
        $xml .= '<xFant>' . $emit->fantasia . '</xFant>';
        $xml .= '<enderEmit>';
        $xml .= '<xLgr>' . $emit->logradouro . '</xLgr>';
        $xml .= '<nro>' . $emit->numero . '</nro>';
        $xml .= '<xCpl>' . $emit->complemento . '</xCpl>';
        $xml .= '<xBairro>' . $emit->bairro . '</xBairro>';
        $xml .= '<cMun>' . $emit->cMun . '</cMun>';
        $xml .= '<xMun>' . $emit->municipio . '</xMun>';
        $xml .= '<UF>' . $emit->uf . '</UF>';
        $xml .= '<CEP>' . $emit->cep . '</CEP>';
        $xml .= '<cPais>' . $emit->cPais . '</cPais>';
        $xml .= '<xPais>' . $emit->pais . '</xPais>';
        $xml .= '<fone>' . $emit->fone . '</fone>';
        $xml .= '</enderEmit>';
        $xml .= '<IE>' . $emit->ie . '</IE>';
        $xml .= '<CRT>' . $emit->regimetributario . '</CRT>';
        $xml .= '</emit>';
        $xml .= '</sistema>';
        
        // Escreve o arquivo
        $fp = fopen('emitente.xml', 'w');
        fwrite($fp, $xml);
        fclose($fp);
        
        if (file_exists("emitente.xml")) {
            header("Content-Type: text/xml");
            header("Content-Length: " . filesize('emitente.xml'));
            header("Content-Disposition: attachment; filename=" . basename('emitente.xml'));
            readfile("emitente.xml");
            exit();
        }
    }
}
