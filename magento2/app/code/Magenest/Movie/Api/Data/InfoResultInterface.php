<?php

namespace Magenest\Movie\Api\Data;

interface InfoResultInterface
{

    const KEY_CODE      = 'code';
    const KEY_DATA      = 'data';
    const KEY_MESSAGE   = 'message';
   
    /**
     * Returns code
     *
     * @return string code
     */
    public function getCode();

    /**
     * Sets Code
     *
     * @param string $code
     * @return $this
     */
    public function setCode($code);

    /**
     * Returns data
     *
     * @return mixed data.
     */
    public function getData();

    /**
     * Sets data
     *
     * @param mixed $data
     * @return $this
     */
    public function setData($data);

    /**
     * Returns message
     *
     * @return string message.
     */
    public function getMessage();

    /**
     * Sets the message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage($message);
}
