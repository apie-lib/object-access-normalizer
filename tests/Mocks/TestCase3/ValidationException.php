<?php
namespace Apie\Tests\ObjectAccessNormalizer\Mocks\TestCase3;

use RuntimeException;

class ValidationException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('A validation error occured');
    }

    public function getError()
    {
        return 'Oh no you killed kenny!';
    }
}
