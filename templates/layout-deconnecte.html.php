<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Sedan+SC&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/mobile.css">

    <?php if (file_exists("assets/css/$page.css")) : ?>
        <link rel="stylesheet" href="assets/css/<?= $page ?>.css">
    <?php endif; ?>

    <script defer src="assets/js/main.js"></script>
    <?php if (file_exists("assets/js/$page.js")) : ?>
        <script defer src="assets/js/<?= $page ?>.js"></script>
    <?php endif; ?>

    <title>MSNConnect</title>
    <meta name="description" content="La renaissance de MSN.">
</head>

<body>
    <?php require  "../templates/$page.html.php"; ?>
</body>
</html>