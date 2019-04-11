<?php

class SudokuGrid 
{
    private $_data = [];

    /**
     * Charge un fichier en fournissant son chemin
     * @param string $filepath Chemin du fichier
     * @return SudokuGrid|null Une instance de la classe si le fichier existe et est valide, null sinon
     */
    public static function loadFromFile($filepath): ?SudokuGrid {
        if(!file_exists($filepath)) { return null; }

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
        $GridIsFull = false; 
            for ( $i = 0; $i < 9 ; $i ++)
            {
                for ( $j = 0; $j < 9 ; $j ++)
                {
                    if(!empty($this->_data[i][j]))
                    {
                       $GridIsFull = true; 
                    }
                    
                }
                
            }
            return $GridIsFull;
    }
    
    /**
     * Retourne les données d'une colonne à partir de son index
     * @param int $columnIndex Index de colonne (entre 0 et 8)
     * @return array Chiffres de la colonne demandée
     */
    public function column(int $columnIndex): array{

        $tmp = [];

        for($i = 0; $i <= 8; $i++) {
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
        if($rowIndex < 9)
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


    /**
     * Retourne les coordonnées de la prochaine cellule à partir des coordonnées actuelles
     * (Le parcours est fait de gauche à droite puis de haut en bas)
     * @param int $rowIndex Index de ligne
     * @param int $columnIndex Index de colonne
     * @return array Coordonnées suivantes au format [indexLigne, indexColonne]
     */
    public function getNextRowColumn(int $rowIndex, int $columnIndex) : array
    {
        $pos = [];
        if($columnIndex == 8 && $rowIndex != 8)
        {
            $pos = [$rowIndex+1, 0];
            return $pos;
        }
        elseif ( $rowIndex == 8 && $columnIndex == 8 )
        {
            $pos = [$rowIndex, $columnIndex];
            return $pos;
        }
        elseif($columnIndex < 8)
        {
            $pos = [$rowIndex, $columnIndex+1];
            return $pos;
        }
    }


    /**
     * Teste si la grille est valide
     * @return bool
     */
    // si isFilled == true 

    //     une boucle x
    //     $this->row(x);

    //         foreach de la row

    //             conditition
    //             si != 0 
    //             return true


    // sinon return false
    public function isValid(): bool {
    
        if(isFilled() == true)
        {
            for($i = 0; $i < 9; $i ++)
            {
                $row = $this->row($i);
                foreach ($row as $value) {
                    if($value != 0)
                    {
                        return true;
                    }
                }
            }
            return false;
        }
    }

    /**
     * Génère l'affichage de la grille
     * @return string
     */
    public function display(): string {

        $tmp = "";

        // 1 ère méthode
        // for ($i = 0; $i < 9 ; $i++)
        // {
        //     for ($j = 0; $j < 9 ; $j++)
        //     {
        //         $tmp += $this->get($i, $j);

        //         if ($j % 9 == 0)
        //         {
        //             $tmp += PHP_EOL;
        //         }
        //     }
        //     return $tmp;
        // }

        // 2 eme méthode
        for ($i = 0; $i < 9 ; $i++)
        {
            $tmp = $tmp.implode(" ", $this->row($i)).PHP_EOL;
        }
        return $tmp;
    }

}

