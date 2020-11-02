<?php
    if (empty($_POST['count']) OR !is_numeric($_POST['count'])) {
        header("location: ../database.php");
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
        header("location: ../database.php");
        exit;
    }

    $data = [];
    $keys = array_keys($files);
    for($i = 0; $i < $count; $i++) {
        $obj = [];
        foreach($keys as $key) {
            $obj[$key] = $files[$key][ array_rand( $files[$key] ) ];
        }
        $data[] = $obj;
    }

    $sql = '';
    $table = $_POST['table'];
    foreach ($data as $key => $value) {
        $sql .= "INSERT INTO $table (" . implode(",", $keys) . ") VALUES (" . implode(",", array_map('createString' ,$value)) . ");\n";
    }

    function createString($value)
    {
        return '"' . $value . '"';
    }

    echo $sql;

?>