<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title>
</head>
<body>
<div class="alert alert-success" role="alert">
Hello {{$email_data['name']}}<br/><br/>
Welcome to CubeHall!<br/>
Please click the link below to verify your email and activate account!<br/><br/>
<a href="http://192.168.1.85/verify?code={{$email_data['verification_code']}}">Cleck here</a>
<br/> <br/>
Thank You!
<br/>
{{env('APP_NAME')}} 
</div>
</body>
</html>