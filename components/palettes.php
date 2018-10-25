<?php

require_once("utility.php");

function getPaletteList() {
    $sql = "SELECT id AS palette_id, name AS palette_name FROM palette";
    $query = pg_query(getDb(), $sql);
    return pg_fetch_all($query);
}

function getPaletteColors($id) {

    $sql = "SELECT c.id AS color_id, c.name AS color_name, c.hex
            FROM color AS c
            JOIN color_palette AS cp ON cp.color_id = c.id
            WHERE cp.palette_id = $id
            ORDER BY c.hex DESC";
    $result = pg_query(getDb(), $sql);

    return pg_fetch_all($result);
}

function deletePalette($id) {
    $db = getDb();
    $sql = "DELETE FROM palette WHERE id = " . $id;
    $result = pg_query($db, $sql);

    if ($result) {
        $GLOBALS["statusMessage"] = "The palette was deleted.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "The palette was not deleted.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }
}

function addPalette($name) {
    $sql = "INSERT INTO palette (name) VALUES ('$name')";
    $result = pg_query(getDb(), $sql);
    if ($result) {
        $GLOBALS["statusMessage"] = "Palette <strong>$name</strong> was added.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "Palette <strong>$name</strong> was not added.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }
}

?>
