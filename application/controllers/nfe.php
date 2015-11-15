<?php
require_once ("secure_area.php");

class NFe extends Secure_area
{

    /**
     * construct
     * Controle de Processos do modulo NFe
     *
     * @name __construct
     */
    function __construct()
    {
        parent::__construct('nfe');
        
        // carrega libraries NFE
        $this->load->library('NFe/ConvertNFePHP');
        $this->load->library('NFe/ToolsNFePHP');
    }

    /**
     * Index
     * Inicializa carregando view fisco/nfe
     *
     * @name index
     */
    function index()
    {
        $this->load->view('fisco/nfe');
    }
    
    
    
    /**
     * view nfe
     * Abre Layout fisco/read trazendo as informações da nota
     */
    function view()
    {
        $this->load->view('fisco/read');
    } 
    
    // ****************************************************************************************************
    // PROCESSO DE ENTRADA
    
    /**
     * ConvertNFE
     * Converte o arquivo txt em um array para ser mais facilmente tratado
     *
     * @name ConvertNFE
     * @param mixed $txt
     *            Path para o arquivo txt, array ou o conteudo do txt em uma string
     * @return string xml construido
     */
    function ConvertNFE($arqFileText)
    {
        if (is_file($arqFileText)) {
            $xml = $this->CI_ConvertNFePHP->nfetxt2xml($arqFileText);
            if ($xml != '') {
                $data['htmlspecialchars'] = '<pre>';
                $data['htmlspecialchars'] .= htmlspecialchars($xml);
                $data['htmlspecialchars'] .= '</pre><br>';
            }
        }
        ;
    }

    /**
     * Este � o Metodo onde insere a NFE na Base de Dados
     * Neste Metodo recebe os os paramentros como um Integer
     * para determinal se o processo é de "INSERT" ou "UPDATE".
     *
     * Ha um ARRAY que e construido por parametros na forma de
     * "STRING", atravez do metodo "$this->input->post()"
     *
     * @param Integer $NFe_id            
     */
    function saveNFeDB($NFe_id = -1)
    {
        $NFe_data = array(
            
            // ************************************************************* //
            
            'natureza' => $this->input->post('natureza'),
            'CFOP' => $this->input->post('CFOP'),
            'vendedor' => $this->input->post('vendedor'),
            'destinatario' => $this->input->post('destinatario'),
            'CNPJCPF' => $this->input->post('CNPJCPF'),
            'emissao' => $this->input->post('emissao'),
            'endereco' => $this->input->post('endereco'),
            'bairro' => $this->input->post('bairro'),
            'cep' => $this->input->post('cep'),
            'datasaida' => $this->input->post('datasaida'),
            'municipio' => $this->input->post('municipio'),
            'uf' => $this->input->post('uf'),
            'fone' => $this->input->post('fone'),
            'inscricao' => $this->input->post('inscricao'),
            'horasaida' => $this->input->post('horasaida'),
            
            // ************************************************************* //
            
            'baseCalcICMS' => $this->input->post('baseCalcICMS'),
            'valorICMS' => $this->input->post('ValorICMS'),
            'BCalcICMSsubst' => $this->input->post('BCalcICMSsubst'),
            'valorICMSsubst' => $this->input->post('valorICMSsubst'),
            'desconto' => $this->input->post('desconto'),
            'valorTotal' => $this->input->post('valorTotal'),
            'valorFrete' => $this->input->post('valorFrete'),
            'valorSeguro' => $this->input->post('valorSeguro'),
            'outrasDespesas' => $this->input->post('outrasDespesas'),
            'valorIPI' => $this->input->post('valorIPI'),
            
            // ************************************************************* //
            
            'transportadora' => $this->input->post('transportadora'),
            'TfreteConta' => $this->input->post('freteConta'),
            'TcodigoANTT' => $this->input->post('codigoANTT'),
            'TplacaVeic' => $this->input->post('placaVeic'),
            'TVUF' => $this->input->post('TVUF'),
            'TCNPJCPF' => $this->input->post('TCNPJCPF'),
            'Tendereco' => $this->input->post('Tendereco'),
            'Tmunicipio' => $this->input->post('Tmunicipio'),
            'TUF' => $this->input->post('TUF'),
            'TIE' => $this->input->post('TIE'),
            
            // ************************************************************* //
            
            'dadosAdicionais' => $this->input->post('dadosAdicionais')
        );
        
        if ($this->NFe->saveNFe($NFe_data, $NFe_id)) {
            // processa assinatura
        } else {
            // não foi possivel salvar
        }
    }
    
    // ****************************************************************************************************
    // FIM // PROCESSO DE ENTRADA
    
    // ****************************************************************************************************
    // PROCESSO DE ASSINADAS
    
    /**
     * Este é o método de assinatura digital do xml da NFe
     * Esse método recebe a NFe como uma "string" com o conte�do do xml e o
     * nome da "tag" xml que deverá ser assinada
     *
     * @name SingXML
     * @param mixed $arqFileText
     *            Path para o arquivo txt array ou o conteudo do txt em uma string
     * @return string xml contruido
     *        
     */
    function signXML($arqFileText)
    {
        
        // verifique se o xml existe
        if (is_file($arqFileXML)) {
            
            // se o xml for achado então carregue o xml todo em uma string
            $XML_File = file_get_contents($arqFileXML);
            
            // tente assinar o xml na tag "XML_File", pois se trata de uma NFe
            if ($signn = $this->ToolsNFePHP->signXML($XML_File, 'infNFe')) {
                
                // se houve retorno do método então o xml foi assinado
                echo "NFe foi Assinada ..<br />";
                
                // determina o novo local depois de assinado
                $set_name = explode('.', $XML_File);
                $novonome = $set_name[1] . '-sign.xml';
                
                // tente gravar esse xml assinado na nova localização
                if (file_put_contents($novonome, $signn)) {
                    
                    // a gravação foi um sucesso, apague o arquivo xml original
                    unlink($XML_File);
                    echo "SUCESSO !!! NFe assinada em $novonome. <br />";
                } else {
                    
                    echo "FALHA na grava��o da NFe Assinada!! <br />";
                }
            } else {
                
                echo "FALHA NFe não assinada!!!! <br />";
                echo $nfe->errMsg;
            } // fim signXML
        } // fim file existe
    }
    
    // ****************************************************************************************************
    // FIM // PROCESSO DE ASSINADAS
    
    // ****************************************************************************************************
    // PROCESSO DE VALIDADAS
    
    /**
     * Este é um exemplo de uso do m�todo validXML que confere se o xml
     * assinado de uma NFe atende aos crit�rios do seu schema
     * Note que n�o devemos aplicar esse m�todo as NFe que j� tenham incorporados
     * seus proptocolos de aceita��o da SEFAZ pois vai gerar erro.
     * E isso � l�gico pois esse m�todo deve ser usado antes de submeter a NFe ao SEFAZ
     * e portanto antes de receber o protocolo.
     *
     * @name validXML
     * @param mixed $arqFileText
     *            Path para o arquivo txt array ou o conteudo do txt em uma string
     * @return string xml contruido
     */
    
    // carregue a classe
    function validXML($arqFileXML)
    {
        
        // Verifica se a o arquivo da NFe assinado que deseja validar
        if (file_exists($arqFileXML)) {
            
            // se o arquivo existir, carregue o em uma string
            $docXml = file_get_contents($XML);
            
            // coloque o path completo para o schema a ser usado
            $pathXSD = '/var/www/nfephp2/schemes/PL_006j/nfe_v2.00.xsd';
            
            // verifique a validade do xml em rela��o ao seu schema construtivo
            $aRet = $this->ToolsNFePHP->validXML($docXml, $pathXSD);
            
            if (! $aRet['status']) {
                echo str_replace("\n", "<br>", $aRet['error']);
            }
        }
    }
    
    // ****************************************************************************************************
    // FIM // PROCESSO DE VALIDADAS
    
    // ****************************************************************************************************
    // PROCESSO DE ENVIO
    function statusSEFAZ()
    {}

    /**
     * Com este metodo envia o xml ja validado e assinado para o SEFAZ
     *
     * @name sendXML
     * @param unknown_type $arqFileXML            
     * @return String XML Concluido
     */
    function sendXML($arqFileXML)
    {
        
        // determina o tipo de conector 1-SOAP ou 2-cURL
        $modSOAP = '2'; // usando cURL
                        
        // obter um numero de lote
        $lote = substr(str_replace(',', '', number_format(microtime(true) * 1000000, 0)), 0, 15);
        
        // montar o array com a NFe
        $aNFe = array(
            0 => file_get_contents($arqFileXML)
        );
        
        // enviar o lote
        if ($aResp = $this->ToolsNFePHP->sendLot($aNFe, $lote, $modSOAP)) {
            if ($aResp['bStat']) {
                echo "Numero do Recibo : " . $aResp['nRec'] . ", use este numero para obter o protocolo ou informa��es de erro no xml com Recibo.";
            } else {
                echo "Houve erro !! $this->ToolsNFePHP->errMsg";
            }
        } else {
            echo "houve erro !!  $this->ToolsNFePHP->errMsg";
        }
        echo '<BR><BR><h1>DEBUG DA COMUNICA��O SOAP</h1><BR><BR>';
        echo '<PRE>';
        echo htmlspecialchars($this->ToolsNFePHP->soapDebug);
        echo '</PRE><BR>';
    }
    
    // ****************************************************************************************************
    // FIM // PROCESSO DE ENVIO
    
    // ****************************************************************************************************
    // PROCESSO DE RETORNO
    
    /**
     * A solicitacao da situacao da NFe atraves do numero do
     * recibo de uma nota enviada e recebida com sucesso pelo SEFAZ
     *
     * @name validXML
     * @param unknown_type $recibo            
     * @return string xml contruido
     */
    function ConsultaRecibo($recibo)
    {
        
        // determina o tipo de conector 1-SOAP ou 2-cURL
        $modSOAP = '2'; // usando cURL
        $chave = '';
        
        // determina o ambiente 1-produ��o 2-homologa��o
        $tpAmb = '2'; // homologacao
        
        if ($aResp = $this->ToolsNFePHP->getProtocol($recibo, $chave, $tpAmb, $modSOAP)) {
            // houve retorno mostrar dados
            print_r($aResp);
        } else {
            // n�o houve retorno mostrar erro de comunica��o
            echo "Houve erro !! $nfe->errMsg";
        }
    }
    
    // ****************************************************************************************************
    // FIM // PROCESSO DE RETORNO
}