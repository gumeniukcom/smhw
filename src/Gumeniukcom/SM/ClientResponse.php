<?php


namespace Gumeniukcom\SM;


class ClientResponse
{
    /**
     * @var mixed
     */
    private $meta;

    /**
     * @var mixed
     */
    private $data;

    /**
     * ClientResponse constructor.
     * @param mixed $meta
     * @param mixed $data
     */
    public function __construct($meta, $data)
    {
        $this->meta = $meta;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }


}