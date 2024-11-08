<?php

namespace App\Http\Repositories\Notifications;

use App\Notifications\AutoNotification;
use App\User;

class NotificationRepository{

    protected $process;

    protected $notifDetails;

    public function __construct($process)
    {
        $this->process=$process;
        $this->notifDetail=(Object)([
            'status' => "",
            'details'=>"",
            'msg'=>"",
            'process'=>$process,
        ]);
    }

    public function success($msg,$details){
        $toUser=$this->getUsers();
        $this->notifDetail->details=$details;
        $this->notifDetail->msg=$msg;
        $this->notifDetail->status="OK";
        $this->send($toUser);
    }

    public function failed($msg,$details){
        $toUser=$this->getUsers();
        $this->notifDetail->details=$details;
        $this->notifDetail->msg=$msg;
        $this->notifDetail->status="Error";
        $this->send($toUser);
    }

    public function alert($msg,$details){
        $toUser=$this->getUsers();
        $this->notifDetail->details=$details;
        $this->notifDetail->msg=$msg;
        $this->notifDetail->status="Alert";
        $this->send($toUser);
    }

    private function getUsers(){
        $process=$this->process;
       return User::whereHas('notifyroles', function($q) use ($process) {$q->where('name', $process);})->get();
    }

    private function send($toUser){
        \Notification::send($toUser, new AutoNotification($this->notifDetail));
    }


}
