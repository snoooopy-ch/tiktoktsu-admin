<?php

namespace App;

use Mail;
use Log;
use App\Models\User;

class MailManager
{
    public static function send_register($info) {

        $mailData = [
            'subject'   => $info['subject'],
            'msg'       => $info['msg'],
            'email'     => $info['email'],
            'name'      => $info['name'],
        ];

        try {
            Mail::send('emails.register', $mailData, function($message) use ($info) {
                $message->to($info['email'])->subject($mailData['Register']);
            });

            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
