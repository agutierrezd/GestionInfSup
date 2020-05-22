<?php
/* ejemplo 1 */

$i = 1;
while ($i <= 10) {
    echo $i++;  /* el valor presentado sería
                   $i antes del incremento
                   (post-incremento) */
}

/* ejemplo 2 */

$i = 1;
while ($i <= 10):
    echo $i;
    $i++;
endwhile;
?>
