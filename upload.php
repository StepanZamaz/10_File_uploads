<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload souboru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body class="container">
<?php
//var_dump($_POST);
//var_dump($_FILES);


    if ($_FILES) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = strtolower( pathinfo( $targetFile, PATHINFO_EXTENSION ) );

    $uploadSuccess = true;

    if ($_FILES['uploadedName']['error'] != 0) {
        echo "CHyba serveru při uploadu";
        $uploadSuccess = false;

    }

    //kontrola existence
    elseif (file_exists($targetFile)) {
        echo "Soubor již existuje";
        $uploadSuccess = false;
    }

    //kontrola velikosti
    elseif ($_FILES['uploadedName']['size'] > 8000000) {
        echo "Soubor je příliš velký";
        $uploadSuccess = false;
    }


    //kontrola typu
    elseif ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "bmp" && $fileType !== "gif" && $fileType !== "mkv" && $fileType !== "avi" && $fileType !== "mp4" && $fileType !== "mp3") {
        echo "Soubor má špatný typ";
        $uploadSuccess = false;
    }

    $html = "";
    if ( !$uploadSuccess) {
        echo "Došlo k chybě uploadu";
    } else {
        //vše je OK
        //přesun souboru
        if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)) {
            echo "Soubor '". basename($_FILES['uploadedName']['name']) . "' byl uložen.";

            if($fileType === "jpg" || $fileType === "png" || $fileType === "bmp" || $fileType === "gif"){
                $html .= "<img src='".$targetDir."/".basename($_FILES['uploadedName']['name'])."'>";

            }
            else if($fileType === "mkv" || $fileType === "avi" || $fileType === "mp4"){
                $html .= "<video width='300' height='300' controls>";
                $html .= "<source src='".$targetDir."/".basename($_FILES['uploadedName']['name'])."' >";
                $html.= "</video>";
            }
            else if($fileType === "mp3"){
                $html .= "<audio controls>";
                $html .= "<source src='".$targetDir."/".basename($_FILES['uploadedName']['name'])."' >";
                $html.= "</audio>";
            }

        } else {
            echo "Došlo k chybě uploadu";
        }
    }


    // vykreslení souborů v uploads

}

?>
<form method='post' action='' enctype='multipart/form-data'><div class="mb-3">
        Select image to upload:
        <input type="file" name="uploadedName" accept="file_extension|audio/*|video/*|image/*|media_type" class="form-control"/>
        <input type="submit" value="Nahrát" name="submit" class="btn btn-primary"/>
    </div></form>
<?php
echo $html;
?>
</body>
</html>
