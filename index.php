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
            $safeColorHex = htmlentities($_POST["colorhex"]);
            addColor($safeColorName, $safeColorHex);
            break;
    }


    // Do we need to alert the user of anything?
    if ($GLOBALS["statusMessage"] != '') {
        echo '<div class="alert ' . $GLOBALS["statusMessageClass"] . '">' . $GLOBALS["statusMessage"] . "</div>\n";
    }

    // Load data
    $colorList = getColorList();
    $paletteList = getPaletteList();
    // echo '<pre>' . print_r($paletteList, true) . '</pre>';

?>

    <div class="row mt-4">

        <div class="col col-12 col-md-6">
            <h3 class="text-center mb-4">Palettes</h3>

            <div>
<?php
    foreach ($paletteList as $palette) {
?>
                <div class="card mb-4">
                    <h5 class="card-title text-center ml-3 mt-4 mb-4"><?= $palette['palette_name'] ?></h5>
                    <ul class="list-group list-group-flush">
<?php
        if ($palette['colors']) {
            foreach ($palette['colors'] as $color) {
?>
                        <li class="list-group-item p-0">
                            <div class="row no-gutters">
                                <div class="col colorSwatch" style="background-color: #<?=$color["hex"]?>"></div>
                                <div class="col pl-2 my-auto"><?=$color["color_name"]?><br /><code>#<?=$color["hex"]?></code></div>
                        </li>
<?php
            }
        }
?>
                    </ul>
                </div>
<?php
    }
?>
            </div>

        </div>

        <div class="col col-12 col-md-6">
            <h3 class="text-center mb-4">Colors</h3>

            <form class="form-inline justify-content-around" method="post" action="">
                <input class="form-control mr-2 mb-4" name="colorname" value="" placeholder="Color name...">
                <div class="input-group mr-2 mb-4">
                    <div class="input-group-prepend">
                        <div class="input-group-text">#</div>
                    </div>
                    <input type="text" class="form-control" name="colorhex" placeholder="Hex value...">
                </div>
                <button type="submit" class="btn btn-success mb-4">Add</button>
                <input type="hidden" name="action" value="addcolor">
            </form>

            <div>
<?php
    foreach ($colorList as $color) {
?>
                <div class="row no-gutters mb-4">
                    <div class="col-4 colorSwatch" style="background-color: #<?=$color["hex"]?>"></div>
                    <div class="col-6 pl-2 my-auto"><?=$color["name"]?><br /><code>#<?=$color["hex"]?></code></div>
                    <div class="col-2 text-right my-auto">
                        <form method="post" action="">
                            <input type="hidden" name="colorid" value="<?=$color["id"]?>">
                            <input type="hidden" name="action" value="deletecolor">
                            <button class="btn" type="submit"><i class="text-danger far fa-trash-alt"></i></button>
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
