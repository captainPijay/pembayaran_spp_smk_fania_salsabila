<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\WhacenterChannel;
use App\Services\WhacenterService;
use Illuminate\Support\Facades\URL;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TagihanNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $tagihan;
    public function __construct($tagihan)
    {
        $this->tagihan = $tagihan;
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
        //relasi ke siswa belongsto
        //tanggal_tagihan di model tagihan dates[]
        return [
            'tagihan_id' => $this->tagihan->id,
            'title' => 'Tagihan SPP ' . $this->tagihan->siswa->nama,
            'messages' => 'Tagihan SPP Bulan ' . $this->tagihan->tanggal_tagihan->translatedFormat('F Y'),
            'url' => route('wali.tagihan.show', $this->tagihan->id)
        ];
    }
    public function toWhacenter($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'login.url',
            now()->addDays(10),
            [
                'pembayaran_id' => $this->tagihan->id,
                'user_id' => $notifiable->id,
                'url' => route('wali.tagihan.show', $this->tagihan->id)
            ]
        );
        $bulanTagihan = $this->tagihan->tanggal_tagihan->translatedFormat('F Y');
        return (new WhacenterService())
            ->to($notifiable->nohp)
            ->line("Assalamualaikum Bapak Ibu")
            ->line("Berikut Kami Kirim Informasi Tagihan SPP Untuk Bulan " . $bulanTagihan . ' Atas Nama ' . $this->tagihan->siswa->nama)
            ->line('Jika Sudah Melakukan Pembayaran Silahkan Klik Link Berikut ' . $url)
            ->line('Link Ini Berlaku Selama 10 Hari.')
            ->line("JANGAN BERIKAN LINK INI KEPADA SIAPAPUN.");
    }
}
