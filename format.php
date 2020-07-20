<?php
    session_start();
    $data = "";
    $formatData = "";
    if(!empty($_POST['json']) OR !empty($_SESSION['json'])) {
        $data = (!empty($_POST['json'])) ? $_POST['json'] : $_SESSION['json'];
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        if (!empty($_SESSION['error'])) {
            if ($_SESSION['error'] === true) {
                echo "File is ready";
            } else {
                echo $_SESSION['error'];
            }
            unset($_SESSION['error']);
        }
    ?>
    <div id='header'>DataGetter</div>
    <form action='action/formatAction.php' method='POST'>
        <div id='format'>
            <div>
            <label>JSON:
                <textarea name="json"><?= $data; ?></textarea>
            </label>
            </div>
            <div>
                <label>File Name:
                    <input type="text" name="fileName">
                </label>
            </div>
            <div>
                <label>Change format to
                    <select name="changeFormat">
                        <option value="csv">CSV</option>
                        <option value="xml">XML</option>
                    </select>
                </label>
            </div>
        </div>
        <input type='submit'>
        <div class='link'><a href='mix.php'>Mix</a></div>
        <div class='link'><a href='index.php'>Get data</a></div>
    </form>
</body>
</html>