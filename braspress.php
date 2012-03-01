<?php 
	
/**
* Braspress CakePHP Component
*
* Copyright 2012, Luan Garcia.
*
* Licensed under The MIT License
* Redistributions of files must retain the above copyright notice.
*
* @copyright Copyright 2012, Luan Garcia.
* @link http://implementado.com
* @version 1.0
* @author Luan Garcia <luan.garcia@gmail.com>
* @license http://www.opensource.org/licenses/mit-license.php The MIT License
*/
 
class BraspressComponent extends Component {
	public $params = array('url'=>'http://tracking.braspress.com.br/wscalculafreteisapi.dll/wsdl/IWSCalcFrete?wsdl','cnpj'=>00000000000000); 
	public $client; 
	
	public function __construct() {
		parent::__construct();
		//WSDL cache disable
		ini_set("soap.wsdl_cache_enabled", "0"); 
		$this->client = new SoapClient($this->params['url']);
	} 
	
	/**
	 * Retorna todos os metodos no webservice
	 * @return mixed	
	 */
	public function debugMetodos(){
		return $this->client->__getFunctions();		
	}
	
	/**
	 * consulta o prazo de entrega de um cep de origem a um cep de destino retorna o prazo em dias
	 * @param double $cep_origem cep de origem do frete
	 * @param double $cep_destino cep de destino do frete
	 * @return int prazo de entrega em dias
	 */
	public function consultarPrazoEntrega($cep_origem,$cep_destino){
		return $this->client->ConsultaPrazoEntrega((double)$cep_origem,(double)$cep_destino,(double)$this->params['cnpj']);
	}
	/**
	 * retorna todos os metodos no webservice
	 * @param double $cep_origem
	 * @param double $cep_destino
	 * @return mixed
	 */
	public function consultarCep($cep){
		return $this->client->ConsultaCEP((double)$cep,(double)$this->params['cnpj']);
	}
	/**
	 * retorna o custo do frete			 
	 * @param double $origem id de sua origem recebe na afiliação com a transportadora
	 * @param double $cep_origem Cep de origem do frete
	 * @param double $cep_destino Cep de destino do frete
	 * @param double $tipo_frete 1='RODOVIARIO' OU 2='AEREO'
	 * @param double $peso peso do volumes do frete
	 * @param double $valor_nf Valor total da nota fiscal
	 * @param double $volumes número de itens para entrega.			 
	 * @return double valor do frete
	 */
	public function consultarValorFrete($origem,$cep_origem,$cep_destino,$tipo_frete,$peso,$valor_nf,$volumes){
		return $this->client->ValorFreteTotal((double)$this->params['cnpj'], (double)$origem, (double)$cep_origem, (double)$cep_destino, (double)$this->params['cnpj'], (double)$this->params['cnpj'],(string)$tipo_frete, (double)$peso, (double)$valor_nf, (double)$volumes);

	}
	
	/**
	 * retorna a consulta detalhada do frete retona um objeto
	 * contendo os impostos,pedagio e prazo de entrega
	 *
	 * @param double $origem id de sua origem recebe na afiliação com a transportadora
	 * @param double $cep_origem Cep de origem do frete
	 * @param double $cep_destino Cep de destino do frete
	 * @param double $tipo_frete 1='RODOVIARIO' OU 2='AEREO'
	 * @param double $peso peso do volumes do frete
	 * @param double $valor_nf Valor total da nota fiscal
	 * @param double $volumes número de itens para entrega.			 
	 * @return object
	 */
	public function consultarFrete($origem,$cep_origem,$cep_destino,$tipo_frete,$peso,$valor_nf,$volumes){
		return $this->client->CalculaFrete((double)$this->params['cnpj'], (double)$origem, (double)$cep_origem, (double)$cep_destino, (double)$this->params['cnpj'], (double)$this->params['cnpj'],(string)$tipo_frete, (double)$peso, (double)$valor_nf, (double)$volumes);
	}
}

?>