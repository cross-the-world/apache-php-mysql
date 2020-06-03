<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coinmarketcap extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public $cmc = NULL;
	public $currency = NULL;

	public function __construct() {

		parent::__construct();
		$this->config->load('coinmarketcap');
        $api = $this->config->item('apikey');
        $this->currency = $this->config->item('currency');
        $this->cmc = new CoinMarketCap\Api($api);
	}

	public function index() {

		$symbol = $this->input->post('symbol');
		$response = $this->cmc->cryptocurrency()->info(['symbol' => $symbol]);

		$id = $response->data->{$symbol}->id;

		$response = $this->cmc->cryptocurrency()->quotesLatest(['id' => $id]);

		$data['marketcap'] = number_format($response->data->{$id}->quote->{$this->currency}->market_cap/1000000, 3);
		$data['price'] = number_format($response->data->{$id}->quote->{$this->currency}->price, 4);
		$data['circulating'] = number_format($response->data->{$id}->circulating_supply/1000000000, 3);
		$data['total'] = number_format($response->data->{$id}->total_supply/1000000000, 3);
		$data['symbol'] = $symbol;
		echo json_encode($data);
	}
}
