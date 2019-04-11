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

        if(json_last_error() != JSON_ERROR_NONE) { return null; }
        return new SudokuGrid(json_decode(stream_get_contents($file)));
    }

    public function getGrid(): array {
        return $this->_data;
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
        for($i = 0; $i < 9; $i++) {
            if(!in_array(0, $this->row($i))) {
                return true;
            }
        }    
        return false;
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
        $this->_data[$rowIndex][$columnIndex] = $value;
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
    public function isValid(): bool {
        if(!$this->isFilled()) { return false; }

        $range = range(1,9);
        // step 2 
        for($i = 0; $i < 9; $i++) { // numbers
            $tmp = $this->row($i);
            $tmp2 = $this->column($i);
            $tmp3 = $this->square($i);
            sort($tmp);
            sort($tmp2);
            sort($tmp3);
            if($tmp != $range || $tmp2 != $range) {
                return false;
            }
        }
        return true;
        
    }

    public function getSquareId(int $rowIndex, int $columnIndex) : int {

        $square = 0;
        if($rowIndex >= 0 && $rowIndex < 3 && $columnIndex >= 0 && $columnIndex < 3) 
        {
            $square = 0;
        }elseif($rowIndex >= 0 && $rowIndex < 3 && $columnIndex > 2 && $columnIndex < 6) {
            $square = 1;
        }elseif($rowIndex >= 0 && $rowIndex < 3 && $columnIndex > 6 && $columnIndex <= 8) {
            $square = 2;
        }elseif($rowIndex >= 3 && $rowIndex <= 5 && $columnIndex >= 0 && $columnIndex <= 2) {
            $square = 3;
        }elseif($rowIndex >= 3 && $rowIndex <= 5 && $columnIndex >= 3 && $columnIndex <= 5) {
            $square = 4;
        }elseif($rowIndex >= 3 && $rowIndex <= 5 && $columnIndex >= 6 && $columnIndex <= 8) { 
            $square = 5;
        }elseif($rowIndex >= 6 && $rowIndex <= 8 && $columnIndex >= 0 && $columnIndex <= 2) {
            $square = 6;
        }elseif($rowIndex >= 6 && $rowIndex <= 8 && $columnIndex >= 3 && $columnIndex <= 5) {
            $square = 7;
        }elseif($rowIndex >= 6 && $rowIndex <= 8 && $columnIndex >= 6 && $columnIndex <= 8) {
            $square = 8;
        }

        return $square;
    }

    public function isValueValidForPosition(int $rowIndex, int $columnIndex, int $value): bool {

        if(!in_array($value, $this->row($rowIndex)) || !in_array($value, $this->column($columnIndex)) 
        || !in_array($value, $this->square($this->getSquareId($rowIndex, $columnIndex))) ) {
            return true;
        }


        return false;
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
        //     for ($j = 0; $j < 9; $j++)
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

    /**
     * Retourne les données d'un bloc à partir de son index
     * L'indexation des blocs est faite de gauche à droite puis de haut en bas
     * @param int $squareIndex Index de bloc (entre 0 et 8)
     * @return array Chiffres du bloc demandé
     */
    public function square(int $squareIndex): array {
        $array = [];

        $j = 0;
        
        $imin = 0;
        $imax = 2;
        $jmin = 0;
        $jmax = 2;

        

        switch ($squareIndex) {
            case 0:
                $jmax = 2;
                break;
            case 1:
                $jmin = 3;
                $jmax = 5;
                break;
            case 2:
                $jmin = 6;
                $jmax = 8;
                break;
            case 3:
                $imin = 3;
                $imax = 5;
                $jmax = 2;
                break;
            case 4:
                $imin = 3;
                $imax = 5;
                $jmin = 3;
                $jmax = 5;
                break;
            case 5:
                $imin = 3;
                $imax = 5;
                $jmin = 6;
                $jmax = 8;
                break;
            case 6:
                $imin = 6;
                $imax = 8;
                $jmax = 2;
                break;
            case 7:
                $imin = 6;
                $imax = 8;
                $jmin = 3;
                $jmax = 5;
                break;
            default:
                $imin = 6;
                $imax = 8;
                $jmin = 6;
                $jmax = 8;
                break;
        }
        $tmp = [];
        for($i = $imin; $i <= $imax; $i++) {
            for($j = $jmin; $j <= $jmax; $j++){
                array_push($tmp, $this->get($i, $j));
            }
            $array = $tmp;
        }

        return $array;
    }

}

