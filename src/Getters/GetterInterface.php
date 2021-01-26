<?php


namespace Apie\ObjectAccessNormalizer\Getters;

use Symfony\Component\PropertyInfo\Type;
use Apie\ObjectAccessNormalizer\Interfaces\PriorityAwareInterface;

interface GetterInterface extends PriorityAwareInterface
{
    /**
     * Gets name of getter.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * @param object|array $object
     * @return mixed
     */
    public function getValue($object);

    /**
     * Returns type of getter
     *
     * @return Type|null
     */
    public function toType(): ?Type;
}
