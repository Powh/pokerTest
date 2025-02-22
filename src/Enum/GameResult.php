<?php

namespace App\Enum;

enum GameResult: string {
    case Win = '1';
    case Lose = '2';
    case Tie = '3';
}