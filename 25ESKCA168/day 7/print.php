<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome PHP</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, sans-serif;
}

body{
    /* CHANGE THIS LINE TO CHANGE THE BACKGROUND COLOR */
    background: linear-gradient(135deg, #ff69b4, #ffc0cb);

    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.container{
    width:450px;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
    text-align:center;
}

h1{
    color:#d63384;
    margin-bottom:20px;
}

.info{
    background:#ffe6f2;
    margin:12px 0;
    padding:12px;
    border-radius:8px;
    font-size:18px;
}

span{
    color:#e91e63;
    font-weight:bold;
}

.footer{
    margin-top:20px;
    color:#666;
    font-size:14px;
}

</style>

</head>

<body>

<div class="container">

<h1>Welcome to PHP</h1>

<div class="info">
Name:
<span>Prachi</span>
</div>

<div class="info">
Current Date:
<span><?php echo date("Y-m-d"); ?></span>
</div>

<div class="info">
Current Time:
<span><?php echo date("H:i:s"); ?></span>
</div>

<div class="info">
Favourite Programming Language:
<span>PHP</span>
</div>

<div class="info">
Visitor IP Address:
<span><?php echo $_SERVER['REMOTE_ADDR']; ?></span>
</div>

<div class="footer">
PHP Mission Completed ✅
</div>

</div>

</body>
</html>
