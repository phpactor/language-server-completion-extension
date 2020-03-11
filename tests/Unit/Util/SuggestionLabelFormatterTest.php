<?php

namespace Phpactor\Extension\LanguageServerCompletion\Tests\Unit\Util;

use Phpactor\Completion\Core\Suggestion;
use Phpactor\Extension\LanguageServerCompletion\Util\SuggestionLabelFormatter;
use PHPUnit\Framework\TestCase;

class SuggestionLabelFormatterTest extends TestCase
{
    /**
     * @var SuggestionLabelFormatter
     */
    private $formatter;

    protected function setUp(): void
    {
        $this->formatter = new SuggestionLabelFormatter();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFormat(string $type, string $label, string $expected)
    {
        $suggestion = Suggestion::createWithOptions('bar', [
            'type' => $type,
            'label' => $label,
        ]);

        $this->assertSame($expected, $this->formatter->format($suggestion));
    }

    public function dataProvider(): array
    {
        return [
            [Suggestion::TYPE_VARIABLE, '$foo', 'foo'],
            [Suggestion::TYPE_FUNCTION, 'foo', 'foo('],
            [Suggestion::TYPE_FIELD, 'foo', 'foo'],
        ];
    }
}
