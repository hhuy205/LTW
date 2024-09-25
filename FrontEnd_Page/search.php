<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search with Suggestions</title>
    <link rel="stylesheet" href="./assets/css/search.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>


    <div class="search-container">
        <input type="text" id="search-input" placeholder="Search...">
        <div id="suggestions-box" class="suggestions-box"></div>
    </div>

    <script src="./assets/javascript/search.js"></script>
</body>

</html>