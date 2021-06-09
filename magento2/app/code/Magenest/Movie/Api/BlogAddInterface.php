<?php 
namespace Magenest\Movie\Api;
 
 
interface BlogAddInterface {


	/**
	 * POST for Blog api
     * @param string[] $data
	 * @return \Magenest\Movie\Api\Data\InfoResultInterface
	 */
	
	public function getAdd($data);
}