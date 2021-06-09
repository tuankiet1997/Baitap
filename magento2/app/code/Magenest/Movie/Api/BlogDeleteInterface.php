<?php 
namespace Magenest\Movie\Api;
 
 
interface BlogDeleteInterface {


	/**
	 * POST for Blog api
     * @param int $id
	 * @return \Magenest\Movie\Api\Data\InfoResultInterface
	 */
	
	public function Delete($id);
}