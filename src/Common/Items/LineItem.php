<?php

namespace Omnibill\Common\Items;

use Omnibill\Common\Helper;
use Omnibill\Common\ParametersTrait;
use Symfony\Component\HttpFoundation\ParameterBag;

class LineItem implements LineItemInterface
{
    use ParametersTrait;

    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag;

        Helper::initialize($this, $parameters);

        return $this;
    }

    public function getName(): string
    {

    }

    public function getClassification(): string
    {

    }

    public function getQuantity(): float
    {

    }
}