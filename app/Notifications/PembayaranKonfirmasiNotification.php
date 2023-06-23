<?php

namespace App\Notifications;

use App\Channels\WhacenterChannel;
use Illuminate\Bus\Queueable;
use App\Services\WhacenterService;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PembayaranKonfirmasiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $pembayaran;
    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WhacenterChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'pembayaran_id' => $this->pembayaran->id,
            'title' => 'Konfirmasi Pembayaran',
            'messages' => 'Pembayaran Tagihan SPP atas nama ' . $this->pembayaran->tagihan->siswa->nama . 'Telah Di Konfirmasi',
            'url' => route('wali.pembayaran.show', $this->pembayaran->id)
        ];
    }
    public function toWhacenter($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(10),
            [
                'pembayaran_id' => $this->pembayaran->id,
                'user_id' => $notifiable->id,
                'url' => route('wali.tagihan.show', $this->pembayaran->id)
            ]
        );
        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line('Assalamualaikum Bapak/Ibu,')
            ->line('Pembayaran Tagihan SPP Atas Nama ' . $this->pembayaran->tagihan->siswa->nama)
            ->line('Sebesar ' . formatRupiah($this->pembayaran->jumlah_dibayar))
            ->line('Telah Di Konfirmasi')
            ->line('Terimakasih');
    }
}
