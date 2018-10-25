<?php

function getDb() {
    return pg_connect("host=localhost port=5432 dbname=palettemaker user=palettemakeruser password=colorcolorcolor");
}

?>
