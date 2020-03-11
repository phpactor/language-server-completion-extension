<?php

namespace Phpactor\Extension\LanguageServerCompletion\Util;

use Phpactor\Completion\Core\Suggestion;

class SuggestionNameFormatter
{
    public function format(Suggestion $suggestion): string
    {
        $name = $suggestion->name();

        switch ($suggestion->type()) {
            case Suggestion::TYPE_VARIABLE:
                $name = mb_substr($name, 1);
                break;
            case Suggestion::TYPE_FUNCTION:
            case Suggestion::TYPE_METHOD:
                $name = $name . '(';
                break;
        }

        return $name;
    }
}
