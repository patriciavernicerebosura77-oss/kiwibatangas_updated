<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewArticleNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bagong Balita: ' . $this->article->title)
            ->greeting('Hello mula sa Kiwi Batangas Express!')
            ->line('May bago kaming inilathalang balita: "' . $this->article->title . '"')
            ->line($this->article->excerpt)
            ->action('Basahin ang Buong Balita', url('/articles/' . $this->article->slug))
            ->line('Salamat sa patuloy na pag-subaybay!');
    }
}