<?php

class SudokuGrid implements GridInterface
{
    private $data;

    public static function loadFromFile($filepath): ?SudokuGrid {
        if(!file_exists($filepath)) { return false; }

        $file = fopen($filepath, "r");
        
        if(json_last_error() != JSON_ERROR_NONE) { return false; }
        return new SudokuGrid(json_decode(stream_get_contents($file)));
    }

    public function __construct(array $data) {
        $this->$data = $data;
        return true;
    }
    /* Insérer le code ici */
}
