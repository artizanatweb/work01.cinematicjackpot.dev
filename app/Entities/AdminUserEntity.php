<?php

namespace App\Entities;

use App\Models\Language;

class AdminUserEntity
{
    public ?Language $language;

    public function __construct(
        public string  $name,
        public string  $email,
        public string  $password,
        public ?string $phone=null,
        public bool    $active = true,
        public bool    $emailAuthentication = true,
    ) {}

    public function setLanguage(?Language $language = null)
    {
        $this->language = $language;
    }
}
