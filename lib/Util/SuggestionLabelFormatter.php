<?php

namespace Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor\Completion\Core\Suggestion;

class SuggestionLabelFormatter
{
    public function format(Suggestion $suggestion): string
    {
        $label = $suggestion->label();

        switch ($suggestion->type()) {
            case Suggestion::TYPE_VARIABLE:
                $label = mb_substr($label, 1);
                break;
            case Suggestion::TYPE_FUNCTION:
            case Suggestion::TYPE_METHOD:
                $label = $label . '(';
                break;
        }

        return $label;
    }
}
