<?php

require_once("utility.php");

function getPaletteList() {
    $sql = "SELECT id AS palette_id, name AS palette_name FROM palette";
    $query = pg_query(getDb(), $sql);
    $palettes = pg_fetch_all($query);

    foreach ($palettes as &$palette) {
        $palette['colors'] = getPaletteColors($palette['palette_id']);
    }

    return $palettes;
}

function getPaletteColors($id) {

    $sql = "SELECT c.id AS color_id, c.name AS color_name, c.hex
            FROM color AS c
            JOIN color_palette AS cp ON cp.color_id = c.id
            JOIN palette AS p ON p.id = cp.palette_id
            WHERE p.id = $id";
    $result = pg_query(getDb(), $sql);

    return pg_fetch_all($result);
}

function deletePalette($id) {
    $db = getDb();
    // Delete from palette table
    $sql = "DELETE FROM palette WHERE id = " . $id;
    $result = pg_query($db, $sql);

    // Delete from color_palette table
    $sql = "DELETE FROM color_palette WHERE palette_id = " . $id;
    $result = $result && pg_query($db, $sql);

    if ($result) {
        $GLOBALS["statusMessage"] = "The palette was deleted.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "The palette was not deleted.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }

}

?>
