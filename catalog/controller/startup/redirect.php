<?php

class ControllerStartupRedirect extends Controller
{
	public function index()
	{
		$replacedUri = mb_strtolower(str_replace('//', '/', $this->request->server['REQUEST_URI']));
		if ($replacedUri !== $this->request->server['REQUEST_URI']) {
			$this->response->redirect($replacedUri, 301);
		}

		if ($this->request->server['REQUEST_URI'] == '/index.php' && empty($this->request->get)) {
			$this->response->redirect('/', 301);
		}

		if (strpos($this->request->server['REQUEST_URI'], '/index.php?route=common/home') !== false) {
			$this->response->redirect('/', 301);
		}

//		if (!empty($this->request->get['route'])
//			&& isset(get_static_routes()[$this->request->get['route']])
//		) {
//			if (!empty($url = $this->getStaticSystemUrl())) {
//				$this->response->redirect($url, 301);
//			}
//		}
	}

	protected function getStaticSystemUrl()
	{
		if (empty($keyword = $this->getAlias($this->request->get['route']))) {
			return '';
		}

		$getParams = $this->request->get;
		unset($getParams['route']);

		if (!empty($getParams)) {
			$keyword .= "?" . http_build_query($getParams);
		}

		return $keyword;
	}

	private function getAlias($query)
	{
		$result = $this->db->query("SELECT * FROM " . DB_PREFIX . "seo_url WHERE query = '" . $this->db->escape($query) . "'");

		return ($result->num_rows && $result->row['keyword'])
			? $result->row['keyword']
			: '';
	}
}
