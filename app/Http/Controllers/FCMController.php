<?php

namespace App\Http\Controllers;


use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FCMController extends Controller
{
    /**
     * @param $userToken
     * @param $Title
     * @param $Body
     * @param $Data
     * @param $ClickAction
     * @throws \LaravelFCM\Message\InvalidOptionException
     */
    public function sentToOne($userToken, $Title, $Body, $Data, $ClickAction)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($Title);
        $notificationBuilder->setBody($Body)->setSound('default')->setClickAction($ClickAction);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($Data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($userToken, $option, $notification, $data);

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
    }

    /**
     * @param $userTokens
     * @param $Title
     * @param $Body
     * @param $Data
     * @param $ClickAction
     * @throws \LaravelFCM\Message\InvalidOptionException
     */
    public function sentToMultiple($userTokens, $Title, $Body, $Data, $ClickAction)
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder($Title);
        $notificationBuilder->setBody($Body)->setSound('default')->setClickAction($ClickAction);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($Data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($userTokens, $option, $notification, $data);

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();
    }
}
