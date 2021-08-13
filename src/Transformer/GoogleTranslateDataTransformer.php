<?php

namespace App\Transformer;

use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateDataTransformer implements DataTransformer
{
    private GoogleTranslate $tr;
    public function __construct(string $lang)
    {
        $this->tr = new GoogleTranslate($lang);
    }

    /**
     * @param string $str
     * @return string
     * @throws \ErrorException
     */
    public function transform(string $str): string
    {
        return $this->tr->translate($str);
    }
}
