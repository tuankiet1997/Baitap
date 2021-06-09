<?php 
namespace Magenest\Movie\Api;
 
 
interface BlogViewInterface {


	/**
	 * POST for Blog api
     * @param string[] $data
     * @param int $id
	 * @return \Magenest\Movie\Api\Data\InfoResultInterface
	 */
	
	public function getView($data, $id);
}