<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\Lesson;
use App\Models\NotifPreferences;

class SendTopicCommentNotif extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notifData, $sender, $url, $type, $comment, $topic;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifData)
    {
        $this->sender = $notifData['sender'];
        $this->url = $notifData['url'];
        $this->type = $notifData['type'];
        $this->comment = $notifData['comment'];
        $this->topic = $notifData['topic'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (NotifPreferences::getTopicEmailPref($notifiable->id) == 1) { 
            return ['database', 'mail'];
        } else {
            return ['database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $sender = $this->sender;
        $url = $this->url;
        $comment = $this->comment;
        $topic = $this->topic;
        $lesson = Lesson::find($topic->lesson_id);
        $receiver = User::find($notifiable->id);

        $message = new MailMessage();
        $message->subject("A Pelikulove user has commented on the topic, " . $topic->title . "")
            ->greeting('Hi Student ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
            ->line("Pelikulove user  <strong>" . $sender->name . 
            "</strong> has commented on <strong>" . $lesson->title . "</strong>, Topic: <a href=" . $url . "><strong>" . 
            $topic->title . "</strong></a>.")
            ->line('"' . $comment->body . '"')
            ->line('Click <a href=' . $url . '>here</a> to checkout the comment!')
            ->line('<br>')
            ->line('<small>To stop recieving Topic comment emails, Click <a href=' . url('profile/xe/edit/notif') . '>here</a>.</small>');

        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $sender = $this->sender;
        $url = $this->url;
        $type = $this->type;
        $comment = $this->comment;
        $topic = $this->topic;
        $receiver = User::find($notifiable->id);

        return [
            'data' => "User <strong>" . $sender->name . "</strong> has commented on Topic: <strong>" 
            . $topic->title . "</strong>!",
            'url' => $url,
            'type' => $type,
            'topic_id' => $topic->id,
            'comment_id' => $comment->id,
            'sender_id' => $sender->id,
        ];
    }
}
