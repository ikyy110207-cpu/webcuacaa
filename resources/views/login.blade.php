<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Cuaca</title>

<style>

body{
margin:0;
font-family:Arial,sans-serif;
background:#87CEEB;
height:100vh;
display:flex;
justify-content:center;
align-items:center;
}

.card{
width:380px;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

h2{
text-align:center;
margin-bottom:25px;
}

input{
width:100%;
padding:12px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:8px;
box-sizing:border-box;
}

button{
width:100%;
padding:12px;
border:none;
border-radius:8px;
cursor:pointer;
background:#2196F3;
color:white;
font-size:16px;
}

button:hover{
background:#1976D2;
}

p{
text-align:center;
}

</style>

</head>

<body>

<div class="card">

<h2>🌤️ Login Sistem Cuaca</h2>

<form action="/login" method="POST">

@csrf

<input
type="text"
name="username"
placeholder="Masukkan Username"
required>

<input
type="password"
name="password"
placeholder="Masukkan Password"
required>

<button type="submit">

Login

</button>

</form>

<p>

Username : admin

</p>

<p>

Password : 12345

</p>

</div>

</body>

</html>