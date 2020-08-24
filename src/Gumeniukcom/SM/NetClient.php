<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;


class NetClient extends NetClientAbstract implements NetClientInterface
{

    /**
     * @param string $method
     * @param string $methodName
     * @param null $formParams
     * @param array $headers
     * @return NetResponse
     * @throws \Exception
     */
    public function request(string $method, string $methodName, $formParams = null, array $headers = []): NetResponse
    {
        if (!$this->isMethodAvailable($method)) {
            $this->logger->error(
                'request called wrong with http method',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                ]
            );
            throw new \Exception('request called wrong with http method');
        }

        $request = curl_init();

        $url = $this->makeUrl($methodName);

        if (!empty($headers)) {

            if (isset($headers['query'])) {
                $formParams = $headers['query'];
                unset($headers['query']);
            }

            curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method == self::HTTP_GET) {
            $queryString = '';
            if (!is_null($formParams)) {
                $queryString = http_build_query($formParams);
            }

            $requestUrl = $url . '?' . $queryString;

            curl_setopt($request, CURLOPT_URL, $requestUrl);
        } elseif ($method == self::HTTP_POST) {
            curl_setopt($request, CURLOPT_URL, $url);
            curl_setopt($request, CURLOPT_POST, true);
            curl_setopt($request, CURLOPT_POSTFIELDS, $formParams);
        }



        curl_setopt($request, CURLOPT_TIMEOUT, $this->requestTimeout);
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, $this->requestTimeout);
        curl_setopt($request, CURLOPT_FAILONERROR, false);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($request, CURLOPT_VERBOSE, true);

        $response = curl_exec($request);
        $statusCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
        $error = curl_error($request);
        if ($error == '') { //workaround because curl_error return empty string (not null)
            $error = null;
        }
        curl_close($request);

        $this->logger->debug(
            'request finished',
            [
                'method' => $method,
                'method_name' => $methodName,
                'status_code' => $statusCode,
                'error' => $error,
            ]
        );

        return new NetResponse($statusCode, $response, $error);
    }

    /**
     * @param string $methodName
     * @return string
     */
    private function makeUrl(string $methodName): string
    {
        return $this->serviceAddr . '/' . $methodName;
    }
}