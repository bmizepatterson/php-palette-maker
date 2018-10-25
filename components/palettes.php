<?php

require_once("utility.php");

function getPaletteList() {
    $sql = "SELECT id AS palette_id, name AS palette_name FROM palette ORDER BY palette_name";
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

function getAddableColors($palette_id) {
    $sql = "SELECT id, name, hex FROM color
            WHERE color.id NOT IN (SELECT color_id FROM color_palette WHERE palette_id = $palette_id)
            ORDER BY name";
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

function getPalette($id) {
    $result = pg_query(getDb(), "SELECT id, name FROM palette WHERE id = $id");
    return pg_fetch_assoc($result);
}

function deleteColorFromPalette($palette_id, $color_id) {
    $sql = "DELETE FROM color_palette WHERE color_id = $color_id AND palette_id = $palette_id";
    $result = pg_query(getDb(), $sql);
    if ($result) {
        $GLOBALS["statusMessage"] = "The color has been removed from this palette.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "Could not remove the selected color from this palette.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }
}

function addColorToPalette($palette_id, $color_id) {
    $sql = "INSERT INTO color_palette (palette_id, color_id) VALUES ($palette_id, $color_id)";
    $result = pg_query(getDb(), $sql);
    if ($result) {
        $GLOBALS["statusMessage"] = "The color has been added to this palette.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "Could not add the selected color to this palette.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }
}

function updatePalette($id, $name) {
    $sql = "UPDATE palette
            SET name = '$name'
            WHERE id = $id";
    $result = pg_query(getDb(), $sql);
    if ($result) {
        $GLOBALS["statusMessage"] = "Palette <strong>$name</strong> has been updated.";
        $GLOBALS["statusMessageClass"] = "alert-success";
    }
    else {
        $GLOBALS["statusMessage"] = "Palette <strong>$name</strong> was not updated.";
        $GLOBALS["statusMessageClass"] = "alert-danger";
    }
}

?>
