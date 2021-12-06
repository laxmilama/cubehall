<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Reminder</title>
</head>
<body>
<div class="alert alert-success" role="alert">
Hello {{$email_data['name']}}<br/><br/>
Thank for connecting with {{$email_data['studio_name']}}!<br/>
Your order has been {{$email_data['status']}}!. You will receive your order soon.<br/><br/>
<br/> <br/>
Thank You!
<br/>
{{$email_data['studio_name']}}
</div>
</body>
</html>