<?php


namespace Infrastructure\Payments\ValueObjects;


class PaymentParams
{
    private $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        if (!$this->params) {
            return [];
        } else {
            return $this->params;
        }
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getParam(string $key): ?string
    {
        $params = $this->getParams();
        return isset($params[$key]) ? $params[$key] : null;
    }

    /**
     * @param string $param
     * @param string $key
     */
    public function setParam(string $param, string $key)
    {
        $params = $this->getParams();
        $params[$key] = $param;
        $this->setParams($params);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParam(string $key): bool
    {
        return array_key_exists($key, $this->getParams());
    }

}
