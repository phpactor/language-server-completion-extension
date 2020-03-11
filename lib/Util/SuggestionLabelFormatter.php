<?php

namespace Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor\Completion\Core\Suggestion;

class SuggestionLabelFormatter
{
    public function format(Suggestion $suggestion): string
    {
        switch ($suggestion->type()) {
            case Suggestion::TYPE_VARIABLE:
                return mb_substr($suggestion->label(), 1);
            case Suggestion::TYPE_FUNCTION:
            case Suggestion::TYPE_METHOD:
                return $suggestion->label() . '(';
            default:
                return $suggestion->label();
        }
    }
}
