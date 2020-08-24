<?php


namespace Gumeniukcom\SM;


class ClientResponse
{
    private $meta;

    private $data;

    /**
     * ClientResponse constructor.
     * @param $meta
     * @param $data
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