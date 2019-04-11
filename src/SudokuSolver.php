<?php

class SudokuSolver implements SolverInterface
{
    /* Insérer le code ici */
    public static function solve(SudokuGrid $grid, int $rowIndex = 0, int $columnIndex = 0): ?SudokuGrid 
    {
        $sudoku = $grid;

        $loose = null;

        $sudoku->isFilled();
        $sudoku->isValid();

        if (isFilled() == true)
        {
            $sudokuOrigin = $sudoku;

            $random = random_int(1, 9);

            $sudoku->isValueValidForPosition($rowIndex, $columnIndex, $random);

            if (isValueValidForPosition() == false)
            {
                if ($rowIndex < 8)
                {
                    $sudoku->isValueValidForPosition($rowIndex, $columnIndex, $random);
                }
                elseif ($rowIndex == 8)
                {
                    $sudoku->isValueValidForPosition($rowIndex, $columnIndex, $random);
                }
            }
            elseif (isValueValidForPosition() == true)
            {
                $sudoku->set($rowIndex, $columnIndex, $random);

            }
        }
        elseif (isValid() == true)
        {
            return $loose;
        }
        
        
    }
}
