<?php

function pengerank($amount){
    $money_amount_from[0] =     0;
    $money_amount_to[0] =       10000;
    $money_amount_from[1] =     $money_amount_to[0];
    $money_amount_to[1] =       100000;
    $money_amount_from[2] =     $money_amount_to[1];
    $money_amount_to[2] =       1000000;
    $money_amount_from[3] =     $money_amount_to[2];
    $money_amount_to[3] =       10000000;
    $money_amount_from[4] =     $money_amount_to[3];
    $money_amount_to[4] =       100000000;
    $money_amount_from[5] =     $money_amount_to[4];
    $money_amount_to[5] =       1000000000;
    $money_amount_from[6] =     $money_amount_to[5];
    $money_amount_to[6] =       10000000000;
    $money_amount_from[7] =     $money_amount_to[6];
    $money_amount_to[7] =       25000000000;
    $money_amount_from[8] =     $money_amount_to[7];
    $money_amount_to[8] =       50000000000;
    $money_amount_from[9] =     $money_amount_to[8];
    $money_amount_to[9] =       INF;

    $money_rank[0] = "NAVer";
    $money_rank[1] = "Arbeider";
    $money_rank[2] = "Langer";
    $money_rank[3] = "Millionær";
    $money_rank[4] = "Gambler";
    $money_rank[5] = "Aksjonær";
    $money_rank[6] = "Oljesjeik <i style='color: black;' class='fas fa-tint'></i>";
    $money_rank[7] = "Hotell-investor <i style='color: silver;' class='fas fa-hotel'></i>";
    $money_rank[8] = "Wolf of Wall St. <i style='color: green;' class='fas fa-dollar-sign'></i>";
    $money_rank[9] = "Skrue McDuck <i style='color: gold;' class='fas fa-coins'></i>";

    $i = 0;
    
    while($i < 10){
        if($amount >= $money_amount_from[$i] && $amount < $money_amount_to[$i]){
            echo $money_rank[$i];
        }
        $i++;
    }
}

?>