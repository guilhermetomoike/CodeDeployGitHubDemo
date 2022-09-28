<?php


namespace App\Channels\Messages;


use Illuminate\Contracts\Support\Arrayable;
use Traversable;

class WhatsAppMessage
{
    public $recipient = [];
    public $message = [];
    public $media = [];

    public static function create()
    {
        return new static();
    }

    public function setRecipient($recipient): self
    {
        if ($this->isArrayOfContact($recipient)) {
            $this->recipient += $this->parseContactArray($recipient);
        } else {
            $this->recipient[] = $recipient;
        }
        return $this;
    }

    public function setMedia(string $mediaName, string $mediaUrl): self
    {
        $this->media[] = ['name' => $mediaName, 'url' => $mediaUrl];
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message[] = $message;
        return $this;
    }

    /**
     * Determine if the given "values" is actually an array of stuffs.
     *
     * @param mixed $address
     * @return bool
     */
    protected function isArrayOfContact($values)
    {
        return is_array($values) ||
            $values instanceof Arrayable ||
            $values instanceof Traversable;
    }

    /**
     * Parse the multi-stuff array into the necessary format.
     *
     * @param array $value
     * @return array
     */
    protected function parseContactArray($value)
    {
        return collect($value)->map(function ($address) {
            return $address;
        })->values()->all();
    }
}