<!DOCTYPE HTML>
    <html>
        <head>
            
        </head>
        <body>
            <?php
            session_start();
            session_destroy();
            header("Location: sign_in.html");
            exit();
            ?>
        </body>
    </html>