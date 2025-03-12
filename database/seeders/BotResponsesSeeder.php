<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BotResponsesSeeder extends Seeder
{
    public function run()
    {
        DB::table('bot_responses')->insert([
            ['user_message' => 'hello', 'bot_response' => 'Hi! How can I assist you today?'],
            ['user_message' => 'how are you', 'bot_response' => 'I am a chatbot, always ready to assist you!'],
            ['user_message' => 'bye', 'bot_response' => 'Goodbye! Have a wonderful day!'],
            ['user_message' => 'what is your name', 'bot_response' => 'I am your LGU chatbot, here to help!'],
        ]);
    }
}
