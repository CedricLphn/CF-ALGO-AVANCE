<?php

class SudokuGrid implements GridInterface
{
    private $_data;

    /**
     * Charge un fichier en fournissant son chemin
     * @param string $filepath Chemin du fichier
     * @return SudokuGrid|null Une instance de la classe si le fichier existe et est valide, null sinon
     */
    public static function loadFromFile($filepath): ?SudokuGrid {
        if(!file_exists($filepath)) { return false; }

        $file = fopen($filepath, "r");

        if(json_last_error() != JSON_ERROR_NONE) { return false; }
        return new SudokuGrid(json_decode(stream_get_contents($file)));
    }

     /**
     * Instancie une grille à partir d'un tableau de données
     * @param array $data Tableau de données
     */
    public function __construct(array $data) {
        $this->_data = $data; // $this->$data[ligne][colonne]
        return true;
    }

    /**
     * Teste si la grille est pleine
     * @return bool
     */
    public function isFilled() : bool
    {
        $GridLength = count($_data);
        $GridIsFull = false; 
            for ( $i = 0; $i < $GridLength ; $i ++)
            {
                for ( $j = 0; $j < $GridLength ; $j ++)
                {
                    if(Empty($_data[i][j]) == true)
                    {
                       return $GridIsFull; 
                    }
                    else {
                        
                        $GridIsfull = true;
                        return $GridIsfull;
                    }
    
                }
    
            }

        }
    
    /**
     * Retourne les données d'une colonne à partir de son index
     * @param int $columnIndex Index de colonne (entre 0 et 8)
     * @return array Chiffres de la colonne demandée
     */
    public function column(int $columnIndex): array{

        $tmp = [];

        for($i = 0; $i < 8; $i++) {
            array_push($tmp, $this->get($i, $columnIndex));
        }

        return $tmp;
    }
    
    /**
     * Retourne les données d'une ligne à partir de son index
     * @param int $rowIndex Index de ligne (entre 0 et 8)
     * @return array Chiffres de la ligne demandée
     */
    public function row(int $rowIndex): array {
        return $this->_data[$rowIndex];
    }

    /**
     * Affecte une valeur dans une cellule
     * @param int $rowIndex Index de ligne
     * @param int $columnIndex Index de colonne
     * @param int $value Valeur
     */
    public function set(int $rowIndex, int $columnIndex, int $value): void {

        if(isValueValidForPosition($rowIndex, $columnIndex, $value) == true)
        {
            $this->_data[$rowIndex][$columnIndex] = $value;
        }
    }


    /**
     * Retourne la valeur d'une cellule
     * @param int $rowIndex Index de ligne
     * @param int $columnIndex Index de colonne
     * @return int Valeur
     */
    public function get(int $rowIndex, int $columnIndex) : int
    {
            return $this ->_data[$rowIndex][$columnIndex];
    }



    public function getNextRowColumn(int $rowIndex, int $columnIndex)
    {
        if( $columnIndex = 9)
        {
            return $this ->_data[$rowIndex][$columnIndex +1];
        }
        else 
        {
            return $this ->_data[$rowIndex+1][$columnIndex];
        }
    }
    /**
     * Teste si la grille est valide
     * @return bool
     */
    public function isValid(): bool {


    }

    /**
     * Génère l'affichage de la grille
     * @return string
     */
    public function display(): string {

        $this->_data[]
    }

}

