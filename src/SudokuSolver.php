<?php

// class SudokuSolver implements SolverInterface
// {
//     /* Insérer le code ici */
//     public static function solve(SudokuGrid $grid, int $rowIndex = 0, int $columnIndex = 0): ?SudokuGrid 
//     {
//         $sudoku = $grid;
//         $sudokuOrigin = $sudoku;

//         $loose = null;
//         if ($sudoku->isFilled() == false)
//         {
//             $random = random_int(1, 9);

//             if ($sudoku->isValueValidForPosition($rowIndex, $columnIndex, $random) == false)
//             {
//                     $tab = $sudoku->getNextRowColumn($rowIndex, $columnIndex); // tableau [ 0 , 1 ]

//                     // for($a = $rowIndex; $a < 9 ; $a++)
//                     // {
//                     //     for($b = $columnIndex+1; $b < 9 ; $b++)
//                     //     {
//                             SudokuSolver::solve($sudoku, $tab[0], $tab[1]);
//                     //     } 
//                     // }
//                     }


//             elseif ($sudoku->isValueValidForPosition($rowIndex, $columnIndex, $random) == true)
//             {
//                 $sudoku->set($rowIndex, $columnIndex, $random);
//                 $tab = $sudoku->getNextRowColumn($rowIndex, $columnIndex);
//                 SudokuSolver::solve($sudoku, $tab[0], $tab[1]);

//             }
//         }
//         elseif ($sudoku->isValid() == true)
//         {
//             return $sudoku;
//         }
//         elseif ($sudoku->isValid() == false)
//         {
//             $tab = $sudoku->getNextRowColumn($rowIndex, $columnIndex);
//             SudokuSolver::solve($sudoku, $tab[0], $tab[1]);
//         }


//     }
// }



class SudokuSolver implements SolverInterface
{
    public static function solve(SudokuGrid $grid, int $rowIndex = 0, int $columnIndex = 0): ?SudokuGrid 
    {
        $copy = $grid;
        
        if($copy->isFilled()) {
            return new SudokuGrid($copy->getGrid());
        }

        $next = [$rowIndex, $columnIndex];


            $copy->display();
            for ($k=1; $k <= 9; $k++)
            {
                if(!in_array($k, $copy->row($rowIndex)) && !in_array($k, $copy->column($columnIndex)) 
                && !in_array($k, $copy->square($copy->getSquareId($rowIndex, $columnIndex))))
                {
                    //var_dump("?");
                    $copy->set($rowIndex, $columnIndex, $k);
                    $next = $copy->getNextRowColumn($rowIndex, $columnIndex);
        
                    SudokuSolver::solve($copy, $next[0], $next[1]);
                }
            }
            $copy->set($rowIndex, $columnIndex, 0);
        
            return $copy;
        }

}

?>