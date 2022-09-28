<?php


namespace App\Services;


use App\Models\TwilioOutgoing;
use App\Models\WhatsappMessageLog;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioService extends Service
{
    /** @var Client */
    private $http;
    /** @var array */
    private $from;

    public const MSG_PRE_GUIA = "Ótimo, segue abaixo suas guias de impostos e boleto dos honorários.!";

    public const MSG_POS_GUIA = "Caso tenha dúvidas, entre em contato com seu gestor";

    public const MSG_ERRO_GUIA = 'Opa, tivemos um problema com sua remessa. nossa equipe de suporte já foi avisada mas 
    se tiver alguma dúvida entre em contato com seu gestor.';

    const MSG_AUTOMATICA = "Essa mensagem é automática do sistema Medb, canal somente para envio de guias.
    \nDemais assuntos tratar com seu gestor ou pelo e-mail: contato@medb.com.br";

    /**
     * TwilioService constructor.
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $this->from = config('services.twilio.number');
        $this->http = new Client(config('services.twilio.sid'), config('services.twilio.token'));
    }

    /**
     * Envia uma ou varias mensagen(s) de texto ou com media para um ou varios numero(s) de whatsapp
     * @param array|string $recipient
     * @param array|string $message
     * @param array $medias
     */
    public function send($recipient, $message, array $medias = [])
    {
        $numbers = $this->validateNumber($recipient);

        foreach ($numbers as $number) {
            $this->sendMessage($number, $message);
            $this->sendMedia($number, $medias);
            sleep(1);
        }
    }

    private function validateNumber($number)
    {
        if (!is_array($number) && (preg_match('/^[0-9]{11}/', $number))) {
            return [$number];
        }
        foreach ($number as $key => $item) {
            if (preg_match('/^[0-9]{11}/', $item)) continue;
            unset($number[$key]);
        }
        abort_if(!count($number), 400, 'nenhum numero válido informado para envio.');
        return $number;
    }

    private function create(string $number, string $text, string $mediaUrl = null)
    {
        try {
            $data['from'] = $this->from;
            $data['body'] = $text;
            if ($mediaUrl) {
                $data['mediaUrl'] = $mediaUrl;
            }
            $response = $this->http->messages->create("whatsapp:+55$number", $data);
            $this->logMessage('outgoing', $number, $text, $mediaUrl, $response->toArray());
        } catch (\Throwable $th) {
            $message = $th->getMessage();
            abort('400', "erro no envio da mensagem ($message)");
        }
    }

    private function sendMessage($number, $message)
    {
        if (is_array($message)) {
            foreach ($message as $msg) {
                $this->create($number, $msg);
            }
        } else {
            $this->create($number, $message);
        }
    }

    private function sendMedia($number, array $medias)
    {
        if (empty($medias)) {
            return;
        }
        foreach ($medias as $media) {
            $this->create($number, $media['name'], $media['url']);
        }
    }

    private function logMessage(string $direction, string $to, string $text, ?string $mediaUrl, array $payload)
    {
        return WhatsappMessageLog::query()->create([
            'direction' => $direction,
            'from' => $this->from,
            'to' => $to,
            'text' => $text,
            'media' => $mediaUrl,
            'payload' => $payload
        ]);
    }

    public function seedSMS( $number,  $data)
    {
        $response = $this->http->messages->create($number, $data);
        return $response ;
    }
}