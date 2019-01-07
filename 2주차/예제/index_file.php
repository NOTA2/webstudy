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
            <li><a href="http://localhost?id=1">Javacript란?</a></li>
            <li><a href="http://localhost?id=2">변수와 상수</a></li>
            <li><a href="http://localhost?id=3">연산자</a></li>
        </ol>
    </nav>
    <div id="control">
        <input type="button" value="white" onclick="document.getElementById('target').className='white'">
        <input type="button" value="black" onclick="document.getElementById('target').className='black'">
    </div>
    <article>
        <?php
            if( empty($_GET['id']) == false ) {
                echo file_get_contents('./txt/'.$_GET['id'].'.txt');
            }
        ?>
    </article>
</body>

</html>