<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function GetNotifications(){
        $notificaciones= auth()->user()->unreadNotifications()->get();
        return ['notificaciones'=>$notificaciones->take(15)->toArray(),'count'=> $notificaciones->count()];
    }

    public function SetUnreadNotifications(){
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['info'=>'success']);
    }


    public function list(){
        $notificaciones=auth()->user()->Notifications()->select('data','read_at','created_at')->get();
        return Datatables::of($notificaciones)
        ->addColumn('action', function ($notificacion) {
            $div="<div class='".getNotifiColor($notificacion->data['status'])."' style='min-width:100%'> ";
            if($notificacion->read_at)
                $div.="<h5>".$notificacion->data['msg']."</h5>";
           else
                $div.="<h4><stong>".$notificacion->data['msg']."</strong></h4>";
                $div.="<p>".$notificacion->data['details']."</p>";
            $div.="<p><small><i class='far fa-clock '></i><span>".$notificacion->created_at->diffForHumans()."</span></small></p>";
            return   $div;
        })
        ->removeColumn('data')
        ->make(true);
    }

    public function index(){
        return view('notificaciones.index');
    }
}




