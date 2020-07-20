<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mix</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id='header'>DataGetter</div>
    <form action='action/mixAction.php' method='POST'>
        <div id='files'>
            <label>Count:<input type='number' name='count' min='1'></label>
            <div id='filesNames'>
                <?php
                    $jsonFiles = glob("data/*.json");
                    
                    foreach($jsonFiles as $file) {
                        ?>
                        <div><span><?= preg_replace("/data\//", "", $file); ?></span>
                            <select name='<?= preg_replace("/data\//", "", $file); ?>[]'>
                                <option value='false' selected>No</option>
                                <option value='true'>Yes</option>
                            </select>
                            <input type='text' placeholder='nameField' name='<?= preg_replace("/data\//", "", $file); ?>[]'>
                        </div>
                        <?php
                    }

                ?>
            </div>
        </div>
        <input type='submit'>
        <div class='link'><a href='format.php'>Format</a></div>
        <div class='link'><a href='index.php'>Get data</a></div>
    </form>
</body>
</html>