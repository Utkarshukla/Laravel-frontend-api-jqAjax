<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
   
</head>
<body>
    <script>
        var token = localStorage.getItem('user_token');
        if (window.location.pathname == '/login' || window.location.pathname == '/register') {
            if (token !=null) {
                window.open('/profile','_self');
            }
        } else {
            if (token ==null) {
                window.open('/login','_self');
            }
        }
    </script>
    