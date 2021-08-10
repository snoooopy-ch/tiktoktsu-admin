<?php

namespace App;

use Mail;
use Log;

class MailManager
{
    public static function send_contactmail($title, $content, $email, $support) {

        $mailData = [
            'title'     => $title,
            'content'   => $content,
            'email'     => $email,
        ];

        try {
            Mail::send('emails.contact', $mailData, function($message) use ($support){
                $message->to($support)->subject('お問い合わせのアラム');
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
