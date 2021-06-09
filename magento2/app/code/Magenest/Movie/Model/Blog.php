<?php
namespace Magenest\Movie\Model;
 
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class Blog extends AbstractModel
{

    const CACHE_TAG = 'magenest_blog';

	protected $_cacheTag = 'magenest_blog';

	protected $_eventPrefix = 'magenest_blog';

    protected function _construct()
    {
        $this->_init('Magenest\Movie\Model\ResourceModel\Blog');
    }

    public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}

    public function getLastName()
    { 
        return $this->getData('lastname'); 
    }

    public function getFirstName() 
    { 
        return $this->getData('firstname');
    }

    public function getUserName() 
    { 
        return $this->getData('username'); 
    }
}