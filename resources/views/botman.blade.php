<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: "Source Sans Pro", sans-serif;
                margin: 0;
                padding: 0;
                background: radial-gradient(#57bfc7, #45a6b3);
            }

            .container {
                display: flex;
                height: 100vh;
                align-items: center;
                justify-content: center;
            }

            .content {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content" id="app">
                <botman-tinker api-endpoint="/botman" user-id="my-custom-user-id"></botman-tinker>
            </div>
        </div>
        
        <script src="js/app.js"></script>
    </body>
</html>
