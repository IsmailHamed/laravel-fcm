<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class NotificationController extends Controller
{
    public function notify()
    {

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder('my title test');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => 'my_data']);
        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fQDauCReZzw:APA91bGqPVy6s7X4HnfdY4UrYz4QfNjor-QkBJg6E5JqG3U8QWP1DG2wkQI_YJ6FaHfadPT5I_KgRQSQn_MCQME507HOaZyYGiRWPJaR19iQESvzVteEosWd_mGx3_pDacZ1UESAcgDX";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

// return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

// return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }
}
