<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets Victoria</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/favicon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poetsen+One&display=swap">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poetsen+One&family=Ysabeau+SC:wght@1..1000&display=swap">
    <style>
        .main-content img {
            width: 40%;
            border-radius: 50%;
            float: right;
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            max-width: 800px;
            margin: auto;
        }

        label {
            grid-column: 1 / 3;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        input[type="submit"],
        button[type="reset"] {
            grid-column: 1 / 2;
            padding: 10px 15px;
            margin-top: 20px;
            cursor: pointer;
        }

        button[type="reset"] {
            grid-column: 2 / 3;
        }
    </style>
    <script src="js/main.js" defer></script>
</head>