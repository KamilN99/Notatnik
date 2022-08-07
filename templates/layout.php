<html lang="pl">

<head>
    <title>Notatnik</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link href="/public/style.css" rel="stylesheet">
</head>

<body class="body">
    <div class="wrapper">
        <div class="header">
            <h1>Notatnik</h1>
        </div>

        <div class="container">
            <div class="menu">
                <ul>
                    <?php if (isset($_SESSION['id'])) : ?>
                        <li><a href="/">Strona główna</a></li>
                        <li><a href="/?action=create">Nowa notatka</a></li>
                        <li><a href="/?action=logout">Wyloguj</a></li>
                    <?php else : ?>
                        <li><a href="/?action=login">Zaloguj</a></li>
                        <li><a href="/?action=register">Zarejestruj</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="page">
                <?php require_once("templates/pages/$page.php"); ?>
            </div>
        </div>

        <div class="footer">
            <p>footer</p>
        </div>
    </div>
</body>

</html>