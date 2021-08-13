<?php

namespace App\Transformer;

interface DataTransformer
{
    public function transform(string $str): string;
}
