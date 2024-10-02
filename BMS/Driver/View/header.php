<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Bus Management System</title>
    <?php
        require_once '../../../Common/Common file/cdn.php';
    ?>
    <link rel="stylesheet" href="../../../Common/Common file/style.css">
    <!-- Tamil font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php
    if ($_SESSION['languageCode'] == 'en') {
        ?>
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
            /* Apply the English font to body and textual elements */
            body, p, h1, h2, h3, h4, h5, h6, span, div {
                font-family: "Poppins", sans-serif !important;
            }
        </style>
        <?php
    } else if ($_SESSION['languageCode'] == 'ta'){
        ?>
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@300;400;500;600;700&display=swap");
            /* Apply the Tamil font to body and textual elements */
            body, p, h1, h2, h3, h4, h5, h6, span, div {
                font-family: "Noto Sans Tamil", sans-serif !important;
            }
        </style>
        <?php
    } else {
        ?>
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap");
            /* Apply the English font to body and textual elements */
            body, p, h1, h2, h3, h4, h5, h6, span, div {
                font-family: "Poppins", sans-serif !important;
            }
        </style>
        <?php
    }

    ?>
    <style>
        /* Ensure Font Awesome icons are unaffected */
        .fa, .fas, .far, .fal, .fab {
            font-family: 'Font Awesome 5 Free' !important;
        }
    </style>
</head>
<body>