<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Xin Chào : {{ Auth::user()->name}}</h1>
    <a href="../logout">Cuts</a>
    <a href="../home/forgot-password">Forgot Password</a>
</body>
</html>