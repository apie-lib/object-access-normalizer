<?php
namespace Apie\Tests\ObjectAccessNormalizer\Errors;

use Apie\ObjectAccessNormalizer\Errors\ErrorBag;
use Apie\ObjectAccessNormalizer\Exceptions\ValidationException;
use Apie\Tests\ObjectAccessNormalizer\Mocks\TestCase1\ValidationException as ValidationExceptionCase1;
use Apie\Tests\ObjectAccessNormalizer\Mocks\TestCase2\ValidationException as ValidationExceptionCase2;
use Apie\Tests\ObjectAccessNormalizer\Mocks\TestCase3\ValidationException as ValidationExceptionCase3;
use Apie\Tests\ObjectAccessNormalizer\Mocks\TestCase4\ValidationException as ValidationExceptionCase4;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

class ErrorBagTest extends TestCase
{
    /**
     * @dataProvider worksProvider()
     */
    public function test_works(array $expectedErrors, array $expectedExceptions, string $prefix, string $fieldName, Throwable $throwable)
    {
        $testItem = new ErrorBag($prefix);
        $testItem->addThrowable($fieldName, $throwable);
        $this->assertEquals($expectedErrors, $testItem->getErrors());
        $this->assertEquals($expectedExceptions, $testItem->getExceptions());
    }

    public function worksProvider()
    {
        $exception = new RuntimeException('Error message');
        yield [
            ['field' => ['Error message']],
            ['field' => [$exception]],
            '',
            'field',
            $exception,
        ];

        yield [
            ['prefix.field' => ['Error message']],
            ['prefix.field' => [$exception]],
            'prefix',
            'field',
            $exception,
        ];

        $exception = new ValidationExceptionCase1();
        yield [
            ['field' => ['A validation error occured']],
            ['field' => [$exception]],
            '',
            'field',
            $exception,
        ];

        yield [
            ['prefix.field' => ['A validation error occured']],
            ['prefix.field' => [$exception]],
            'prefix',
            'field',
            $exception,
        ];

        $exception = new ValidationExceptionCase2();
        yield [
            [
                'field' => ['error 1'],
                'field.field 2' => ['error 2'],
            ],
            [
                'field' => [$exception],
                'field.field 2' => [$exception],
            ],
            '',
            'field',
            $exception,
        ];

        yield [
            [
                'prefix.field.field' => ['error 1'],
                'prefix.field.field 2' => ['error 2'],
            ],
            [
                'prefix.field.field' => [$exception],
                'prefix.field.field 2' => [$exception],
            ],
            'prefix',
            'field',
            $exception,
        ];

        $exception = new ValidationExceptionCase3();

        yield [
            [
                'field.0' => ['Oh no you killed kenny!'],
            ],
            [
                'field.0' => [$exception],
            ],
            '',
            'field',
            $exception,
        ];

        yield [
            [
                'prefix.field.0' => ['Oh no you killed kenny!'],
            ],
            [
                'prefix.field.0' => [$exception],
            ],
            'prefix',
            'field',
            $exception,
        ];
        $exception = new ValidationExceptionCase4();
        yield [
            [
                'field' => ['error 1', 'error 2'],
                'field.field 2' => ['error 3'],
            ],
            [
                'field' => [$exception, $exception],
                'field.field 2' => [$exception],
            ],
            '',
            'field',
            $exception,
        ];

        yield [
            [
                'prefix.field.field' => ['error 1', 'error 2'],
                'prefix.field.field 2' => ['error 3'],
            ],
            [
                'prefix.field.field' => [$exception, $exception],
                'prefix.field.field 2' => [$exception],
            ],
            'prefix',
            'field',
            $exception,
        ];

        $exception = new ValidationException(['' => ['no key']]);
        yield [
            [
                '' => ['no key'],
            ],
            [
                '' => [],
            ],
            '',
            'field',
            $exception,
        ];

        yield [
            [
                '' => ['no key'],
            ],
            [
                '' => [],
            ],
            'prefix',
            'field',
            $exception,
        ];
    }
}
