<?php

namespace App;

use App;
use Spatie\TranslationLoader\LanguageLine as BaseLanguageLine;

class LanguageLine extends BaseLanguageLine
{
    /**
     * @param string $locale
     *
     * @return string
     */
    public function getTranslation(string $locale = ''): ?string
    {
        if ($locale === '') {
            $locale = App::getLocale();
        }

        return parent::getTranslation($locale);
    }

    /**
     * @param string $locale
     * @param string $value
     *
     * @return BaseLanguageLine
     */
    public function setTranslation(string $value, string $locale = '')
    {
        if ($locale === '') {
            $locale = App::getLocale();
        }

        return parent::setTranslation($locale, $value);
    }
}
