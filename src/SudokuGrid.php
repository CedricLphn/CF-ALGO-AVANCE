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

    public function isFilled() : bool
    {
        $GridLength = count($Grid);
        $GridIsFull = false; 
            for ( $i = 0; $i < $GridLength ; $i ++)
            {
                for ( $j = 0; $j < $GridLength ; $j ++)
                {
                    if(Empty($Grid[i][j]) == true)
                    {
                       return $GridIsFull = false; 
                    }
                    else {
                        return $GridIsfull = true;
                    }
    
                }
    
            }

        }

    /* Insérer le code ici */
    
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
     * Teste si la grille est valide
     * @return bool
     */
    public function isValid(): bool {


    }

    /**
     * Génère l'affichage de la grille
     * @return string
     */
    public function display(): string;

}
