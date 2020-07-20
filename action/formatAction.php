<?php
    session_start();
    unset($_SESSION['error']);
    if (empty($_POST["json"]) OR empty($_POST["changeFormat"]) OR !in_array($_POST['changeFormat'], ["csv","xml"], true) OR empty($_POST['fileName'])) {
        header("location: ../format.php");
        exit;
    }

    $data = json_decode($_POST['json'], true);

    $_SESSION['json'] = $_POST['json'];

    if($data == null) {
        $_SESSION['error'] = "Wrong format of json";
        header("location: ../format.php");
        exit;
    }

    $fileName = $_POST['fileName'];
    $path = "../format/";

    $status = false;
    switch($_POST['changeFormat']) {
        case "csv": 
            $status = toCSV($data);
            break;
        case "xml":
            $status = toXML($data);
        default:
            break;
    }
    
    if ($status == false) {
        $_SESSION['error'] = "Cant create file";
    }

    header("location: ../format.php");
    exit;

    function toCSV ($data)  {
        global $path, $fileName;

        $file = implode(",", array_keys($data[0]));
        for ($i=0; $i < count($data); $i++) { 
            $file .= "\n" . implode("," ,array_values($data[$i]));
        }

        $status = file_put_contents($path . $fileName . ".csv", $file);

        return $status;
    }

    function toXML($data) {
        global $path, $fileName;
        
        $keys = array_keys($data[0]);
        $file = '<?xml version="1.0" encoding="UTF-8" ?>';

        for ($i = 0; $i < count($data); $i++) { 
            $obj = $data[$i];

            $file .= "\n<$i>\n";
            
            for($j = 0; $j < count($keys); $j++) {
                $key = $keys[$j];
                $value = $obj[$key];
                $file .= "\t<$key>$value</$key>\n";
            }
            $file .= "</$i>";
        }
        
        $status = file_put_contents($path . $fileName . ".xml", $file);

        return $status;
    }
?>