<!DOCTYPE html> 
<html> 
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Login Page </title>
<link rel="stylesheet" href="{{asset('css/superadmincss/style.css')}}" />
</head>  
<body>  
    <center> <h1> That Branch Ecom</h1> </center> 
    <form action="{{url('/admin')}}" method="post"> @csrf
        <div class="loginform"> 
            <label>Email : </label> 
            <input type="text" placeholder="Enter Email" name="email" id="email"required>
            <label>Password : </label> 
            <input type="password" placeholder="Enter Password" name="password" required>
            <button type="submit" class="loginbutton">Login</button> 
           
            Forgot <a href="#"> password? </a> 
        </div> 
    </form>   
</body>   
</html>

 
