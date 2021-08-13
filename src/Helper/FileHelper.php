<?php

namespace App\Helper;

class FileHelper
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function getContents(): string
    {
        return file_get_contents($this->filename);
    }

    public function WriteToFile(string $str): void
    {
        $fp = fopen($this->filename, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }

    public function appendFile(string $str): void
    {
        $fp = fopen($this->filename, 'a');
        fwrite($fp, $str);
        fclose($fp);
    }

}
