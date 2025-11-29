<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\Language;

class LanguageRepository implements Interfaces\LanguageRepository
{

    public function findByCode(string $code): ?Language
    {
        return Language::where('code', $code)->first();
    }

    public function make(string $code, string $name, Currency $currency, ?int $id = null): Language
    {
        $language = $this->findByCode($code);
        if (!$language) {
            $language = new Language();
        }

        if ($id) {
            $language->id = $id;
        }

        $language->code = $code;
        $language->name = $name;
        $language->flag = get_language_flag($code);
        $language->currency_id = $currency->id;
        $language->saveOrFail();

        return $language;
    }
}
