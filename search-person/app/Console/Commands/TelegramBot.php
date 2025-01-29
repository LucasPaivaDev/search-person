<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Api;

class TelegramBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:telegram-bot';
    protected $description = 'Captura as mensagens do telegram para as buscas';

    public function handle()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        // Obtém as atualizações mais recentes
        $updates = $telegram->getUpdates();

        foreach ($updates as $update) {
            $message = $update->getMessage();
            $chatId = $message->getChat()->getId();
            $text = $message->getText();

            // Lógica para processar o comando
            if ($text === '/start') {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Olá! Envie um CPF, placa de carro ou número de telefone para buscar informações.',
                ]);
            } else {
                // Aqui você processará a busca de dados
                $response = $this->buscarDados($text);
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => $response,
                ]);
            }
        }
    }

    private function buscarDados($input)
    {
        // Aqui você implementará a lógica de busca
        return "Você enviou: $input. Em breve, este bot buscará dados!";
    }
}
