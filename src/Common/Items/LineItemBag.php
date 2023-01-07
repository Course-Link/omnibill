<?php

namespace Omnibill\Common\Items;

class LineItemBag implements \IteratorAggregate, \Countable
{
    public function __construct(
        protected array $items = []
    )
    {
    }

    public function all(): array
    {
        return $this->items;
    }

    public function replace(array $items = array())
    {
        $this->items = array();

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add($item)
    {
        if ($item instanceof LineItemInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new LineItem($item);
        }
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}