<?php

class ControllerExtensionModuleRecentlyViewed extends Controller
{
	public function index($setting)
	{
		$this->load->language('extension/module/recently_viewed');

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

		$data['button_cart'] = $this->language->get('button_cart');
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		$data['products'] = array();

		if (!$setting['limit']) {
			$setting['limit'] = 5;
		}

		$results = $this->getRecentProducts($setting['limit']);

		if ($results) {
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				$images = $this->model_catalog_product->getProductImages($result['product_id']);

				if (isset($images[0]['image']) && !empty($images[0]['image'])) {
					$images = $images[0]['image'];
					$thumb_swap = $this->model_tool_image->resize($images, $setting['width'], $setting['height']);
				} else {
					$thumb_swap = "";
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}

				$data['products'][] = array(
					'product_id' => $result['product_id'],
					'thumb' => $image,
					'thumb_swap' => $thumb_swap,
					'name' => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price' => $price,
					'special' => $special,
					'tax' => $tax,
					'rating' => $rating,
					'href' => $this->url->link('product/product', 'product_id=' . $result['product_id'])
				);
			}
			return $this->load->view('extension/module/recently_viewed', $data);
		}
	}

	public function getRecentProducts($limit = null)
	{
		if (is_null($limit)) {
			$limit = 5;
		}

		return $this->model_catalog_product->getProductsByIds(
			$this->getRecentProductIDs($limit)
		);
	}

	private function getRecentProductIDs($limit)
	{
		$results = array();

		$current_product_id = false;
		if (isset($this->request->get['product_id'])) {
			$current_product_id = (int)$this->request->get['product_id'];
		}

		if (isset($this->request->cookie['recently_viewed']) && !empty($this->request->cookie['recently_viewed'])) {
			$recently_viewed = unserialize(base64_decode($this->request->cookie['recently_viewed']));
			// sort by in recent viewed order
			uasort($recently_viewed, function ($a, $b) {
				return strtotime($a) < strtotime($b);
			});

			// if user is on product detail page then do not show current product in recently_viewed list
			if ($current_product_id) {
				unset($recently_viewed[$current_product_id]);
			}

			$recently_viewed_keys = array_keys($recently_viewed);
			if (!empty($recently_viewed_keys)) {
				$results = array_slice($recently_viewed_keys, 0, (int)$limit);
			}
		}

		return $results;
	}
}