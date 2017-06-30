<?php
/**
 * Created by PhpStorm.
 * User: tienc
 * Date: 6/5/2017
 * Time: 9:11 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class MyMail extends Model
{
    public static function sendEmail($mailTo, $mailSubject, $mailContent){
        $data = array('name'=>"Virat Gandhi");
        Mail::send('mail', $data, function($message) {
            $message->to('tiench189.hut@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
            $message->from('xyz@gmail.com','Virat Gandhi');
        });
    }
}