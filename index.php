<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="dist/css/output.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <title>PHP Palette Maker</title>
  </head>
  <body class="container mt-4">

      <h1 class="text-center mb-5">PHP Palette Maker</h1>

<?php

    require_once("components/colors.php");
    require_once("components/palettes.php");

    $action = isset($_POST["action"]) ? $_POST["action"] : '';
    $editcolor = false;
    $editpalette = false;
    $GLOBALS["statusMessage"] = '';
    $GLOBALS["statusMessageClass"] = 'alert-success';


    // Basic routing!
    switch ($action) {
        case "deletecolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            deleteColor($safeColorId);
            break;
        case "addcolor":
            $safeColorName = htmlentities($_POST["colorname"]);
            $safeColorHex = strtoupper(htmlentities($_POST["colorhex"]));
            addColor($safeColorName, $safeColorHex);
            break;
        case "deletepalette":
            $safePaletteId = htmlentities($_POST["paletteid"]);
            deletePalette($safePaletteId);
            break;
        case "addpalette":
            $safePaletteName = htmlentities($_POST["palettename"]);
            addPalette($safePaletteName);
            break;
        case "addpalettecolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            $safePaletteId = htmlentities($_POST["paletteid"]);
            addColorToPalette($safePaletteId, $safeColorId);
            break;
        case "removepalettecolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            $safePaletteId = htmlentities($_POST["paletteid"]);
            deleteColorFromPalette($safePaletteId, $safeColorId);
            break;
        case "editpalette":
            $safePaletteId = htmlentities($_POST["paletteid"]);
            $editpalette = getPalette($safePaletteId);
            break;
        case "updatepalette":
            $safePaletteId = htmlentities($_POST["paletteid"]);
            $safePaletteName = htmlentities($_POST["palettename"]);
            updatePalette($safePaletteId, $safePaletteName);
            break;
        case "editcolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            $editcolor = getColor($safeColorId);
            break;
        case "updatecolor":
            $safeColorId = htmlentities($_POST["colorid"]);
            $safeColorName = htmlentities($_POST["colorname"]);
            $safeColorHex = strtoupper(htmlentities($_POST["colorhex"]));
            updateColor($safeColorId, $safeColorName, $safeColorHex);
            break;
    }

    // Do we need to alert the user of anything?
    if ($GLOBALS["statusMessage"] != '') {
        echo '<div class="alert ' . $GLOBALS["statusMessageClass"] . '">' . $GLOBALS["statusMessage"] . "</div>\n";
    }

    // Load data
    $colorList = getColorList();
    $paletteList = getPaletteList();
?>

    <div class="row mt-4">

        <div class="col col-12 col-md-6">
            <h3 class="text-center mb-4">Palettes</h3>

            <form class="form-inline justify-content-center mb-5 p-2<?php echo $editpalette ? ' border border-primary' : ''; ?>" method="post" action="">
                <input class="form-control mr-2" name="palettename" value="<?php echo $editpalette ? $editpalette['name'] : ''; ?>" placeholder="Palette name">
<?php
    if ($editpalette) {
?>
                <input type="hidden" name="paletteid" value="<?= $editpalette['id'] ?>">
<?php
    }
?>
                <button type="submit" class="btn <?php echo $editpalette ? 'btn-primary' : 'btn-success'; ?>"><?php echo $editpalette ? 'Update' : 'Add'; ?></button>
                <input type="hidden" name="action" value="<?php echo $editpalette ? 'updatepalette' : 'addpalette'; ?>">
            </form>

            <div>
<?php
    foreach ($paletteList as $palette) {
?>
                <div class="card mb-5">
                    <h5 class="card-title text-center ml-3 mr-3 mt-4 mb-4"><?= $palette['palette_name'] ?></h5>

                    <ul class="list-group list-group-flush">
<?php
        $colors = getPaletteColors($palette['palette_id']);
        if ($colors) {
            foreach ($colors as $color) {
?>
                        <li class="list-group-item p-0">
                            <div class="row no-gutters">
                                <div class="col colorSwatch" style="background-color: #<?=$color["hex"]?>"></div>
                                <div class="col pl-2 my-auto"><?=$color["color_name"]?><br /><code>#<?=$color["hex"]?></code></div>
                                <div class="col-2 my-auto">
                                    <form method="post" action="" class="float-right">
                                        <input type="hidden" name="colorid" value="<?=$color["color_id"]?>">
                                        <input type="hidden" name="paletteid" value="<?=$palette['palette_id']?>">
                                        <input type="hidden" name="action" value="removepalettecolor">
                                        <button class="btn btn-sm" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
                                    </form>
                                </div>
                        </li>
<?php
            }
        } else {
?>
                        <li class="list-group-item"><span class="text-muted">Select a color below to add it to this palette.</span></li>
<?php
        }
?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col text-center">
                                    <form method="post" action="">
                                        <input type="hidden" name="action" value="deletepalette">
                                        <input type="hidden" name="paletteid" value="<?=$palette["palette_id"]?>">
                                        <button class="btn" type="submit"><i class="far fa-trash-alt text-danger"></i></button>
                                    </form>
                                </div>
                                <div class="col text-center">
                                    <form method="post" action="">
                                        <input type="hidden" name="action" value="editpalette">
                                        <input type="hidden" name="paletteid" value="<?=$palette["palette_id"]?>">
                                        <button class="btn" type="submit"><i class="far fa-edit"></i></button>
                                    </form>
                                </div>
<?php
$addableColors = getAddableColors($palette['palette_id']);
if ($addableColors) {
?>
                                <div class="col-8">
                                    <form method="post" action="" class="form-inline">
                                        <input type="hidden" name="action" value="addpalettecolor">
                                        <input type="hidden" name="paletteid" value="<?= $palette['palette_id'] ?>">
                                        <div class="row">
                                                <select name="colorid" class="form-control col-10">
                                                    <option>Add a color</option>
<?php
    foreach ($addableColors as $color) {
?>
                                                    <option value="<?= $color['id'] ?>"><?= $color['name'] ?> (#<?= $color['hex'] ?>)</option>
<?php
    }
?>
                                                </select>
                                                <button type="submit" class="btn col-2"><i class="far fa-plus-square"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
<?php
}
?>
                        </li>
                    </ul>
                </div>
<?php
    }
?>
            </div>

        </div>

        <div class="col col-12 col-md-6">
            <h3 class="text-center mb-4">Colors</h3>

            <form class="form-inline justify-content-center mb-5 p-2<?php echo $editcolor ? ' border border-primary' : ''; ?>" method="post" action="">
                <input class="form-control mr-2" name="colorname" value="<?php echo $editcolor ? $editcolor['name'] : ''; ?>" placeholder="Color name">
                <div class="input-group mr-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">#</div>
                    </div>
                    <input type="text" class="form-control" name="colorhex" size="10" value="<?php echo $editcolor ? $editcolor['hex'] : ''; ?>" placeholder="Hex value">
                </div>
<?php
    if ($editcolor) {
?>
                <input type="hidden" name="colorid" value="<?= $editcolor['id'] ?>">
<?php
    }
?>
                <button type="submit" class="btn <?php echo $editcolor ? 'btn-primary' : 'btn-success'; ?>"><?php echo $editcolor ? 'Update' : 'Add'; ?></button>
                <input type="hidden" name="action" value="<?php echo $editcolor ? 'updatecolor' : 'addcolor'; ?>">
            </form>

            <div>
<?php
    foreach ($colorList as $color) {
?>
                <div class="row no-gutters mb-4">
                    <div class="col-4 colorSwatch" style="background-color: #<?=$color["hex"]?>"></div>
                    <div class="col-6 pl-2 my-auto"><?=$color["name"]?><br /><code>#<?=$color["hex"]?></code></div>
                    <div class="col-2 my-auto">
                        <form method="post" action="" class="float-right">
                            <input type="hidden" name="colorid" value="<?=$color["id"]?>">
                            <input type="hidden" name="action" value="deletecolor">
                            <button class="btn btn-sm p-1" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
                        </form>
                        <form method="post" action="" class="float-right">
                            <input type="hidden" name="colorid" value="<?=$color["id"]?>">
                            <input type="hidden" name="action" value="editcolor">
                            <button class="btn btn-sm p-1" type="submit"><i class="far fa-edit"></i></button>
                        </form>
                    </div>
                </div>

<?php
    }
?>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
