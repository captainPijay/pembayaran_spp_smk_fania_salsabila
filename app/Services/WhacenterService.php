<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhacenterService
{

    protected ?string $to;
    protected array $lines;
    protected string $baseUrl = '';
    protected string $deviceId = '';
    protected $message = '';
    protected $response = '';
    protected $responseBody = '';


    /**
     * constructor.
     * @param array $lines
     */
    public function __construct($lines = [])
    {
        $this->lines = $lines;
        $this->baseUrl = 'https://app.whacenter.com/api';
        $this->deviceId = '';
    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    private function sendRequest($params): bool
    {
        try {
            $this->response = Http::withoutVerifying()->get($this->baseUrl . $params);
            $this->message = 'OK';
            $this->response->onError(function ($q) {
                return false;
            });
            $this->responseBody = $this->response->body();
            return true;
        } catch (\Throwable $th) {
            $this->message = $th->getMessage();
            return false;
        }
    }

    public function requestDeviceStatus()
    {
        return $this->sendRequest('/statusDevice?device_id=' . $this->deviceId);
    }

    public function getDeviceStatus(): bool
    {
        $this->requestDeviceStatus();
        $responseBody = json_decode($this->responseBody);
        $status = $responseBody->status;
        if ($status == true) {
            $data = $responseBody->data;
            $this->message = $data->status;
            if ($data->status == 'CONNECTED') {
                return true;
            }
        }
        return false;
    }

    public function send(): bool
    {
        if ($this->to != '' && $this->deviceId != '') {
            $params = 'device_id=' . $this->deviceId . '&number=' . $this->to . '&message=' . urlencode(implode("\n", $this->lines));
            return $this->sendRequest('/send?' . $params);
        }
        return false;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
