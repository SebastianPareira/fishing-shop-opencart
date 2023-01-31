<?php
class ControllerCheckoutCheckout extends Controller {
	const UKRAINE_ID = 220;

	private $error = array();

	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->load->language('checkout/checkout');

		$orderTotal = $this->calculateOrderTotal();
		$this->getPaymentMethods($orderTotal);

		$data['payment_methods'] = $this->session->data['payment_methods'];

		if (empty($data['payment_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_payment'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->validateForm();
		}

		$data['error_email'] = isset($this->error['email']) ? $this->error['email'] : '';
		$data['error_password'] = isset($this->error['password']) ? $this->error['password'] : '';
		$data['error_confirm'] = isset($this->error['confirm']) ? $this->error['confirm'] : '';
		$data['error_telephone'] = isset($this->error['telephone']) ? $this->error['telephone'] : '';
		$data['error_firstname'] = isset($this->error['firstname']) ? $this->error['firstname'] : '';
		$data['error_lastname'] = isset($this->error['lastname']) ? $this->error['lastname'] : '';
		$data['error_city'] = isset($this->error['city']) ? $this->error['city'] : '';
		$data['error_address_1'] = isset($this->error['address_1']) ? $this->error['address_1'] : '';
		$data['error_payment_method'] = isset($this->error['error_payment_method']) ? $this->error['error_payment_method'] : '';

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->getOpenGraph()->setTitle($this->language->get('heading_title'));


		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Required by klarna
		if ($this->config->get('payment_klarna_account') || $this->config->get('payment_klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['logged'] = $this->customer->isLogged();

		$data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
		$data['action'] = $this->url->link('checkout/checkout', '', true);
		$data['action_account_login'] = $this->url->link('account/login/ajax', '', true);
		$data['action_checkout_confirm'] = $this->url->link('checkout/confirm', '', true);
		$data['action_checkout_validate'] = $this->url->link('checkout/checkout/validate', '', true);

		$formInputs = [
			'account',
			'email',
			'password',
			'confirm',
			'comment',
		];

		if (!$this->customer->isLogged()) {
			$formInputs = array_merge($formInputs, [
				'telephone',
				'firstname',
				'lastname',
				'city',
				'address_1',
			]);
		}

		foreach ($formInputs as $formInput) {
			$data[$formInput] = isset($this->request->post[$formInput]) ? $this->request->post[$formInput] : '';
		}

		if ($this->customer->isLogged()) {
			$formInputs = [
				'telephone' => 'getTelephone',
				'firstname' => 'getFirstName',
				'lastname' => 'getLastName',
			];

			foreach ($formInputs as $key => $value) {
				if (isset($this->request->post[$key])) {
					$data[$key] = $this->request->post[$key];
				} else {
					$data[$key] = !empty($this->customer->$value()) ? $this->customer->$value() : '';
				}
			}

			$this->load->model('account/address');
			$address = $this->model_account_address->getAddress($this->customer->getAddressId());

			if ($address) {
				if (!empty($this->request->post['city'])) {
					$data['city'] = $this->request->post['city'];
				} else {
					$data['city'] = !empty($address['city']) ? $address['city'] : '';
				}

				if (!empty($this->request->post['address_1'])) {
					$data['address_1'] = $this->request->post['address_1'];
				} else {
					$data['address_1'] = !empty($address['address_1']) ? $address['address_1'] : '';
				}
			} else {
				$data['city'] = isset($this->request->post['city']) ? $this->request->post['city'] : '';
				$data['address_1'] = isset($this->request->post['address_1']) ? $this->request->post['address_1'] : '';
			}
		}

		unset($this->session->data['payment_methods']);

		$this->response->setOutput($this->load->view('checkout/checkout', $data));
	}

	public function validate()
	{
		$json = array();

		$orderTotal = $this->calculateOrderTotal();
		$this->getPaymentMethods($orderTotal);

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateForm()) {
			$this->savePostDataToSession();
			unset($this->session->data['payment_methods']);
			$json['success'] = true;
		} else {
			$json['success'] = false;
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	private function validateForm()
	{
		if (!$this->customer->isLogged() && $this->request->post['account'] == 'register') {
			if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
				$this->error['email'] = $this->language->get('error_email');
			}

			if (!isset($this->error['email'])) {
				$this->load->model('account/customer');
				$customer = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

				if ($customer) {
					$this->error['email'] = 'Пользователь с таким email существует';
				}
			}

			if ((utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) < 4) || (utf8_strlen(html_entity_decode($this->request->post['password'], ENT_QUOTES, 'UTF-8')) > 40)) {
				$this->error['password'] = $this->language->get('error_password');
			}

			if ($this->request->post['confirm'] != $this->request->post['password']) {
				$this->error['confirm'] = $this->language->get('error_confirm');
			}
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
			$this->error['city'] = $this->language->get('error_city');
		}

		if ((utf8_strlen(trim($this->request->post['address_1'])) < 3) || (utf8_strlen(trim($this->request->post['address_1'])) > 128)) {
			$this->error['address_1'] = $this->language->get('error_address_1');
		}

		if (!isset($this->request->post['payment_method'])
			|| !isset($this->session->data['payment_methods'][$this->request->post['payment_method']])
		) {
			$this->error['error_payment_method'] = $this->language->get('error_payment');
		}

		return !$this->error;
	}

	private function savePostDataToSession()
	{
		if (!$this->customer->isLogged()) {
			if ($this->request->post['account'] == 'register') {
				$this->registerCustomer();
//				$redirect = $this->registerCustomer();
//				if ($redirect != false) {
//					return $redirect;
//				}
			} else {
				$this->session->data['account'] = 'guest';
				$this->session->data['guest']['customer_group_id'] = $this->config->get('config_customer_group_id');
				$this->session->data['guest']['firstname'] = $this->request->post['firstname'];
				$this->session->data['guest']['lastname'] = $this->request->post['lastname'];
				$this->session->data['guest']['email'] = get_guest_email();
				$this->session->data['guest']['telephone'] = $this->request->post['telephone'];
				$this->session->data['guest']['custom_field'] = array();
				$this->session->data['guest']['shipping_address'] = 1;
			}
		}

		$this->session->data['payment_address'] = $this->getAddress();
		$this->session->data['shipping_address'] = $this->getAddress();

		$this->session->data['comment'] = strip_tags($this->request->post['comment']);

		$this->session->data['payment_method'] = $this->getPaymentMethod();
		$this->session->data['shipping_method'] = $this->getShippingMethod();

		return false;
	}

	private function registerCustomer()
	{
		$customer_group_id = $this->config->get('config_customer_group_id');
		$data = array(
			'customer_group_id' => $customer_group_id,
			'firstname' => $this->request->post['firstname'],
			'lastname' => $this->request->post['lastname'],
			'email' => $this->request->post['email'],
			'telephone' => $this->request->post['telephone'],
			'password' => $this->request->post['password'],
			'confirm' => $this->request->post['confirm'],
			'company' => '',
			'address_1' => $this->request->post['address_1'],
			'address_2' => '',
			'city' => $this->request->post['city'],
			'postcode' => '',
			'country_id' => self::UKRAINE_ID,
			'zone_id' => 0,
			'newsletter' => '1',
			'shipping_address' => '1',
		);

		$customer_id = $this->model_account_customer->addCustomer($data);

		// Default Payment Address
		$this->load->model('account/address');

		$address_id = $this->model_account_address->addAddress($customer_id, $data);

		// Set the address as default
		$this->model_account_customer->editAddressId($customer_id, $address_id);

		// Clear any previous login attempts for unregistered accounts.
		$this->model_account_customer->deleteLoginAttempts($data['email']);

		$this->session->data['account'] = 'register';

		$this->customer->login($this->request->post['email'], $this->request->post['password']);

//		$this->load->model('account/customer_group');
//
//		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
//
//		$redirect = false;
//
//		if ($customer_group_info && !$customer_group_info['approval']) {
//			$this->customer->login($this->request->post['email'], $this->request->post['password']);
//		} else {
//			$redirect = $this->url->link('account/success');
//		}
//
//		return $redirect;
	}

	/**
	 * @return array
	 */
	private function getAddress()
	{
		$result = array(
			'firstname' => $this->request->post['firstname'],
			'lastname' => $this->request->post['lastname'],
			'company' => '',
			'address_1' => $this->request->post['address_1'],
			'address_2' => '',
			'postcode' => '',
			'city' => $this->request->post['city'],
			'country_id' => self::UKRAINE_ID,
			'zone_id' => 0,
			'zone' => '',
			'zone_code' => '',
			'custom_field' => array(),
		);

		$this->load->model('localisation/country');
		$country_info = $this->model_localisation_country->getCountry(self::UKRAINE_ID);

		if ($country_info) {
			$result['country'] = $country_info['name'];
			$result['iso_code_2'] = $country_info['iso_code_2'];
			$result['iso_code_3'] = $country_info['iso_code_3'];
			$result['address_format'] = $country_info['address_format'];
		} else {
			$result['country'] = '';
			$result['iso_code_2'] = '';
			$result['iso_code_3'] = '';
			$result['address_format'] = '';
		}

		return $result;
	}

	/**
	 * @return array
	 */
	private function getShippingMethod()
	{
		return array(
			'code' => 'flat.flat',
			'title' => 'Доставка с фиксированной стоимостью доставки',
			'cost' => '5.00',
			'taxt_class_id' => '9',
			'text' => '$5.00',
		);
	}

	/**
	 * @return array
	 */
	private function getPaymentMethod()
	{
		return $this->session->data['payment_methods'][$this->request->post['payment_method']];
	}

	private function calculateOrderTotal() {
		return 100;
	}

	/**
	 * @return void
	 */
	private function getPaymentMethods($total)
	{
		$method_data = array();

		$this->load->model('setting/extension');

		$results = $this->model_setting_extension->getExtensions('payment');

		$recurring = $this->cart->hasRecurringProducts();

		foreach ($results as $result) {
			if ($this->config->get('payment_' . $result['code'] . '_status')) {
				$this->load->model('extension/payment/' . $result['code']);

				$method = $this->{'model_extension_payment_' . $result['code']}->getMethod([
					'country_id' => self::UKRAINE_ID,
					'zone_id' => 0,
				], $total);

				if ($method) {
					if ($recurring) {
						if (property_exists($this->{'model_extension_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_extension_payment_' . $result['code']}->recurringPayments()) {
							$method_data[$result['code']] = $method;
						}
					} else {
						$method_data[$result['code']] = $method;
					}
				}
			}
		}

		$sort_order = array();

		foreach ($method_data as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $method_data);

		$this->session->data['payment_methods'] = $method_data;
	}
}
