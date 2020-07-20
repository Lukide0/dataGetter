<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get data from page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id='header'>DataGetter</div>
    <div id='status'>
        <?php
            session_start();
    
            if(isset($_SESSION["error"])) {
                if($_SESSION["error"] == true) {
                    echo "Empty field!";
                } else {
                    echo "File is ready!";
                }
                unset($_SESSION["error"]);
            }

            $data = "";

            if (!empty($_SESSION['data'])) {
                echo $_SESSION['data'];
                unset($_SESSION['data']);
            }

        ?>
    </div>
    <form method="POST" action="action/action.php">
        <div id='or'>
            <label>
                URL:
                <input type="url" name="url" placeholder='url'>
            </label>
            <div>OR</div>
            <label>
                Source Code:
                <textarea name='htmlCode'></textarea>
            </label>
        </div>
        <div id='options'>
            <label>
                Regex:
                <input type="text" name="regex" placeholder='regex' required>
            </label>
            <label>
                Regex Group:
                <input type="number" name="group" placeholder="group">
            </label>
            <label>
                File Name:
                <input type="text" name='fileName' placeholder='fileName'>
            </label>
        </div>
        <input type="submit">
        <button type='submit' value='true' name='try'>Try</button>
    </form>
    <div class='link'><a href='mix.php'>Mix</a></div>
    <div class='link'><a href='format.php'>Format</a></div>
</body>
</html>