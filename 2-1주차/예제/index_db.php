<?php
$conn = mysqli_connect('localhost', 'root', '111111');
mysqli_select_db($conn, 'op');
$result = mysqli_query($conn, "SELECT * FROM topic");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="http://localhost/style.css">
    <title>생활코딩</title>
</head>

<body id='target'>
    <header>
        <h1><a href="http://localhost">JavaScript</a></h1>
    </header>
    <nav>
        <ol>
            <?php
                while($row = mysqli_fetch_assoc($result)){
                    echo '<li><a href="http://localhost/index.php?id='.$row['id'].'">'.$row['title'].'</a></li>\n'
                }
            ?>`
        </ol>
    </nav>
    <div id="control">
        <input type="button" value="white" onclick="document.getElementById('target').className='white'">
        <input type="button" value="black" onclick="document.getElementById('target').className='black'">
    </div>
    <article>
        <?php
            if(empty($_GET['id']) === false ) {
                $sql = 'SELECT * FROM topic WHERE id='.$_GET['id'];
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo '<h2>'.$row['title'].'</h2>';
                echo $row['description'];
            }
        ?>
    </article>
</body>

</html>