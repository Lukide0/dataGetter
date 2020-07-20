<?php
    session_start();

    include_once "../inc/changeTypeVar.php";


    if ((empty($_POST["url"]) AND empty($_POST["htmlCode"])) OR empty($_POST["regex"]) OR empty($_POST["fileName"])) {
        $_SESSION["error"] = true;
        header("location: ../index.php");
        exit;
    }
    if (empty($_POST["htmlCode"])) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $_POST['url']);
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_POST, 1);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, "year=2018&top=1000"); //post params

        $content = curl_exec($curl);
    } else {
        $content = $_POST["htmlCode"];
    }
    
    if(isset($curl) AND curl_error($curl)) {
        $_SESSION["error"] = true;
        header("location: ../index.php");
    } else {

        preg_match_all("/(" . $_POST["regex"] . ")/", $content, $matches, PREG_SET_ORDER, 0);
        $group = (empty($_POST["group"])) ? 1 : intval($_POST["group"]) + 1;

        $result = [];

        foreach ($matches as $match) {
            $result[] = changeTypeVar($match[$group]);
        }

        $filepath = "../data/" . $_POST["fileName"] . ".json";
        if (!empty($_POST['try']) AND $_POST['try'] == 'true') {
            $_SESSION["data"] = json_encode($result);
            header("location: ../index.php");

            try {
                curl_close($curl);
            } catch (\Throwable $th) {
                //throw $th;
            }
            exit;
        }
        else if (file_exists($filepath)) {
            $fileContent = file_get_contents($filepath);
            $fileContent = json_decode($fileContent, true);

            $fileContent = array_merge($fileContent, $result);

            file_put_contents($filepath, json_encode($fileContent));

        } else {
            $json = json_encode($result);
            file_put_contents($filepath, $json);
        }
    }
    try {
        curl_close($curl);
    } catch (\Throwable $th) {
        //throw $th;
    }
    $_SESSION["error"] = false;
    header("location: ../index.php");
    exit;
?>