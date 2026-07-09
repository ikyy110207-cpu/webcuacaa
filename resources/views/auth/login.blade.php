<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Web Cuaca</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#2193b0,#6dd5ed);
            overflow:hidden;
            font-family:Arial,sans-serif;
        }

        .cloud{
            position:absolute;
            background:white;
            width:180px;
            height:60px;
            border-radius:100px;
            opacity:.5;
            animation:cloudMove 30s linear infinite;
        }

        .cloud:before{
            content:"";
            position:absolute;
            width:80px;
            height:80px;
            background:white;
            border-radius:50%;
            top:-35px;
            left:20px;
        }

        .cloud:after{
            content:"";
            position:absolute;
            width:100px;
            height:100px;
            background:white;
            border-radius:50%;
            top:-50px;
            right:20px;
        }

        .cloud1{
            top:10%;
            left:-250px;
        }

        .cloud2{
            top:35%;
            left:-350px;
            animation-duration:40s;
        }

        .cloud3{
            top:65%;
            left:-300px;
            animation-duration:50s;
        }

        @keyframes cloudMove{
            from{
                transform:translateX(0);
            }
            to{
                transform:translateX(1700px);
            }
        }

        .login-card{
            width:400px;
            background:rgba(255,255,255,.15);
            backdrop-filter:blur(15px);
            padding:35px;
            border-radius:20px;
            box-shadow:0 0 25px rgba(0,0,0,.3);
            color:white;
            animation:zoom .8s;
        }

        @keyframes zoom{
            from{
                transform:scale(.7);
                opacity:0;
            }
            to{
                transform:scale(1);
                opacity:1;
            }
        }

        h2{
            text-align:center;
            margin-bottom:25px;
            font-weight:bold;
        }

        .btn-login{
            width:100%;
            background:#0d6efd;
            color:white;
            border:none;
        }

        .btn-login:hover{
            background:#0b5ed7;
        }

        input{
            height:45px;
        }
    </style>

</head>

<body>

<div class="cloud cloud1"></div>
<div class="cloud cloud2"></div>
<div class="cloud cloud3"></div>

<div class="login-card">

    <h2>🌤 Login Web Cuaca</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <input type="email"
            name="email"
            class="form-control"
            placeholder="Masukkan Email"
            required>
        </div>

        <div class="mb-3">
            <input type="password"
            name="password"
            class="form-control"
            placeholder="Masukkan Password"
            required>
        </div>

        <button class="btn btn-login">
            Login
        </button>

    </form>

</div>

</body>
</html>