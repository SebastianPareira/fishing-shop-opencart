<?php

class ModelExtensionModuleRecentlyViewed extends Model
{
	public function isEnabled()
	{
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "extension WHERE `type` = 'module' AND `code` = 'recently_viewed'");
		return $query->num_rows ? true : false;
	}
}