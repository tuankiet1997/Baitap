<?php

namespace Magenest\Movie\Model;

class InfoResultRepository implements \Magenest\Movie\Api\Data\InfoResultInterface
{
    protected $code;
    protected $data;
    protected $message;

    /**
     * Returns code
     *
     * @return string code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns Data
     *
     * @return mixed data.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets Data
     *
     * @param mixed $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Returns Message
     *
     * @return string message.
     */
    public function getMessage()
    {
        return $this->message;

    }

    /**
     * Sets Message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;

    }

   
    
}