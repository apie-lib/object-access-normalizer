<?php

namespace Apie\ObjectAccessNormalizer\Exceptions;

use Apie\ObjectAccessNormalizer\Setters\SetterInterface;
use Throwable;

/**
 * Exception thrown when a value could not be set.
 */
class ObjectWriteException extends ApieException implements LocalizationableException
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param SetterInterface $method
     * @param string $fieldName
     * @param Throwable $previous
     */
    public function __construct(
        SetterInterface $method,
        string $fieldName,
        Throwable $previous
    ) {
        $this->name = $method->getName();
        $message = 'Could not write property "' . $fieldName . '" with ' . $this->name . ': ' . $previous->getMessage();
        parent::__construct(500, $message, $previous);
    }

    public function getI18n(): LocalizationInfo
    {
        return new LocalizationInfo(
            'serialize.write',
            [
                'name' => $this->name,
                'previous' => $this->getPrevious()->getMessage(),
            ]
        );
    }
}
