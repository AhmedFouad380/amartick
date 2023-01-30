<?php

namespace App\Listeners;

use App\Events\InboxCreated;
use App\Models\Admin;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class NotifyPostCreated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(InboxCreated $event)
    {

    }

    /**
     * Handle the event.
     *
     * @param InboxCreated $event
     * @return void
     */
    public function handle(InboxCreated $event)
    {
        $inbox = $event->inbox;


        if ($inbox->sender_type == "admin") {
            $sender = Admin::whereId($inbox->sender_id)->select('id', 'name')->first();
        } elseif ($inbox->sender_type == "user") {
            $sender = User::whereId($inbox->sender_id)->select('id', 'name')->first();
        } else {
            $sender = Supplier::whereId($inbox->sender_id)->select('id', 'name')->first();
        }

        $inbox->sender = $sender->name;
        if ($inbox->receiver_type == "admin") {
            $receiver = Admin::whereId($inbox->receiver_id)->select('id', 'name')->first();
        } elseif ($inbox->receiver_type == "user") {
            $receiver = User::whereId($inbox->receiver_id)->select('id', 'name','device_token')->first();
        } else {
            $receiver = Supplier::whereId($inbox->receiver_id)->select('id', 'name','device_token')->first();
        }

        $inbox->receiver = $receiver->name;
        if ($inbox->receiver_type != "admin") {
            send($receiver->device_token, 'رسالة جديدة', $inbox->message, $inbox->type, $inbox);
        }
//        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/app/amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json');

        $firebase = (new Factory)
            ->withServiceAccount( app_path('amartech-69196-firebase-adminsdk-q996n-4cb7b7513a.json'))
            ->withDatabaseUri('https://amartech-69196-default-rtdb.firebaseio.com/')
            ->createDatabase();

        $newPost = $firebase
            ->getReference('amar/inboxes/'.$inbox->id)
            ->set([
                'title' => 'رسالة جديدة',
                'body' => $inbox->message,
                'inbox' => $inbox,
                'type' => $inbox->type,
                'receiver_type' => $inbox->receiver_type,
                'receiver_id' => $inbox->receiver_id,
                'filter_type_receiver_id'=>$inbox->receiver_type.'_'.$inbox->receiver_id ,
                'id'=>$inbox->id
            ]);
//        echo '<pre>';
//        dd($newPost->getvalue());
    }

}
