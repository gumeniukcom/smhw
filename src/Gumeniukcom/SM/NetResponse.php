<?php


namespace Gumeniukcom\SM;


class NetResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string | null
     */
    private $response;

    /**
     * @var string | null
     */
    private $error;

    /**
     * NetResponse constructor.
     * @param int $statusCode
     * @param string|null $response
     * @param string|null $error
     */
    public function __construct(int $statusCode, $response = null, $error = null)
    {
        $this->statusCode = $statusCode;
        $this->response = $response;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {
        return !is_null($this->error);
    }

}