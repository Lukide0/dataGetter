<?php
    if (empty($_POST['count']) OR !is_numeric($_POST['count'])) {
        header("location: ../mix.php");
        exit;
    }

    $count = $_POST["count"];
    unset($_POST["count"]);

    $files = [];
    $keys = array_keys($_POST);

    foreach($keys as $fileName) {
        if (substr($fileName, -5) == "_json") {

            if(is_array($_POST[$fileName]) AND $_POST[$fileName][0] != 'false' AND strlen($_POST[$fileName][1]) > 0) {
                $file = preg_replace("/_json$/", ".json", $fileName);

                if (file_exists("../data/" . $file)) {
                    if (!isset($files[$_POST[$fileName][1]])) {
                        $files[$_POST[$fileName][1]] = json_decode( file_get_contents( "../data/" . $file), true );
                    } else {
                        $files[$_POST[$fileName][1]] = array_merge( $files[$_POST[$fileName][1]], json_decode( file_get_contents( "../data/" . $file ), true ) );
                    }
                }    
            }
        }
    }

    if (count($files) == 0) {
        header("location: ../mix.php");
        exit;
    }

    $data = [];
    $keys = array_keys($files);
    for($i = 0; $i < $count; $i++) {
        $obj = (object)[];
        foreach($keys as $key) {
            $obj->$key = $files[$key][ array_rand( $files[$key] ) ];
        }
        $data[] = $obj;
    }
    $data = json_encode($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get data from page</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div id='header'>DataGetter</div>
    <div id='json'><?= $data ?></div>
    <div id='jsonSettings'>
        <button type='button' onclick='copy()'>Copy</button>
        <form action='../format.php' method='POST'><input type='hidden' name='json' value='<?= $data ?>'><button type='submit'>Format</button></form>
        <div class='link'><a href='../mix.php'>Mix</a></div>
        <div class='link'><a href='../format.php'>Format</a></div>
        <div class='link'><a href='../index.php'>Get data</a></div>
    </div>
    <script>
    function copy() {
        let range = document.createRange();
        range.selectNode(document.getElementById("json"));
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand("copy");
        window.getSelection().removeAllRanges();
    }
    </script>
    <script src="../main.js"></script>
</body>
</html>