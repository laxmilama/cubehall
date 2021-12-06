<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SignupEmail;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;
class MailController extends Controller
{

    //send mail for email verification
    public static function sendSignupEmail($name, $email, $verification_code){
        // dd($email);
        $data=[
        'name'=>$name,
        'verification_code'=>$verification_code
        ];
        Mail::to($email)->send(new SignupEmail($data));
    }
    public static function sendMail($name,$user_email,$studio_name,$studio_email,$status){
        $data=[
        'name'=>$name,
        'studio_name'=>$studio_name,
        'studio_email'=>$studio_email,
        'status'=>$status
        ];
        Mail::to($user_email)->send(new OrderStatusMail($data));
    }
}