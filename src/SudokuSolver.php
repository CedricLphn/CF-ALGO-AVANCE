<?php

class SudokuSolver implements SolverInterface
{

    public static function solve(SudokuGrid $origin, int $rowIndex = 0, int $columnIndex = 0): ?SudokuGrid 
    {
        if($origin->isValid()) {
            return $origin;
        }
        $grid = new SudokuGrid($origin->getGrid());
        list($rowNext, $columnNext) = $grid->getNextRowColumn($rowIndex, $columnIndex);


        if($origin->get($rowIndex, $columnIndex) == 0) {
            $range = range(1,9);
            while(true) {
              if(count($range) == 0) {
                  return null;
              }  

              $val = array_pop($range);
                if($origin->isValueValidForPosition($rowIndex, $columnIndex, $val)) {
                    $grid->set($rowIndex, $columnIndex, $val);
                    if(!$grid->isValid()) {
                        $result = self::solve($grid, $rowNext, $columnNext);
                        if($result !== null) {
                            return null;
                        }
                    }else {
                        return $grid;
                    }
                }
            }
        }else {
            if($origin->isValid()) {
                return $origin;
            }
            if($grid->get($rowNext, $columnNext) != 0 && $rowIndex >= 8 && $columnNext >= 8){
                return $origin;
            }else {
                $result = self::solve($grid, $rowNext, $columnNext);
                if($result !== null) {
                    return null;
                }
            }

        }

        return null;
    }



}

?>