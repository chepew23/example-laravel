<?php

namespace App\Utils;
use App\Product;

class Importer
{
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function load()
    {
        try {
            return $this->doLoad();
        } catch (\Exception $e) {
            return false;
        }
    }


    protected function doLoad()
    {
        $handler = fopen($this->filePath, 'r');

        if (!$handler) {
            return false;
        }

        $isFirst = true;
        while (($row = fgetcsv($handler, 1000, ";")) !== false) {
            if ($isFirst) {
                $isFirst = false;
                continue;
            }

            $product = new Product();
            $product->name = $row[0];
            $product->detail = $row[1];
            $product->saveOrFail();
        }

        return true;
    }

}

