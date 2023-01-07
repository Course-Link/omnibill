<?php

namespace Omnibill\Common;

use Omnibill\Common\Enums\InvoiceTypeEnum;
use Omnibill\Common\Http\Client;
use Omnibill\Common\Http\ClientInterface;
use Omnibill\Common\Message\AbstractRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

abstract class AbstractGateway implements GatewayInterface
{
    use ParametersTrait {
        setParameter as traitSetParameter;
        getParameter as traitGetParameter;
    }

    protected ClientInterface $httpClient;

    protected HttpRequest $httpRequest;

    public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
    {
        $this->httpClient = $httpClient ?: $this->getDefaultHttpClient();
        $this->httpRequest = $httpRequest ?: $this->getDefaultHttpRequest();
        $this->initialize();
    }

    public function getShortName(): string
    {
        return Helper::getGatewayShortName(get_class($this));
    }

    public function initialize(array $parameters = []): self
    {
        $this->parameters = new ParameterBag;

        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }

        Helper::initialize($this, $parameters);

        return $this;
    }

    public function getDefaultParameters(): array
    {
        return [];
    }

    public function getParameter(string $key): mixed
    {
        return $this->traitGetParameter($key);
    }

    public function setParameter(string $key, mixed $value): static
    {
        return $this->traitSetParameter($key, $value);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->getParameter('currency'));
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    public function supportsCreateInvoice(): bool
    {
        return method_exists($this, 'createInvoice');
    }

    public function supportsSendInvoice(): bool
    {
        return method_exists($this, 'sendInvoice');
    }

    protected function createRequest(string $class, array $parameters): AbstractRequest
    {
        $obj = new $class($this->httpClient, $this->httpRequest);

        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }

    protected function getDefaultHttpClient(): ClientInterface
    {
        return new Client();
    }

    protected function getDefaultHttpRequest(): HttpRequest
    {
        return HttpRequest::createFromGlobals();
    }
}
