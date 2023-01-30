<?php

namespace Database\Seeders;

use App\Models\Inbox;
use Illuminate\Database\Seeder;

class InboxSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 4; $i++) {
            $inbox = new Inbox();
            $inbox->message = "body";
            $inbox->receiver_id = 1;
            $inbox->receiver_type = "admin";
            $inbox->type = "mail";
            $inbox->sender_type = "user";
            $inbox->sender_id = 17;
            $inbox->save();
        }
    }
}
