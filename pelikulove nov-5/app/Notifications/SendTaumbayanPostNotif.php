<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\ForumPost;
use App\Models\NotifPreferences;

class SendTaumbayanPostNotif extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notifData, $sender, $url, $type, $thread, $post_id;

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
        $this->thread = $notifData['thread'];
        $this->post_id = $notifData['post_id'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if (NotifPreferences::getTambayanEmailPref($notifiable->id) == 1) { 
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
        $type = $this->type;
        $thread = $this->thread;
        $receiver = User::find($notifiable->id);
        $post_id = $this->post_id;
        $post = ForumPost::find($post_id);

        $message = new MailMessage();
        if ($thread->author_id == $notifiable->id) {
            // If User is the Author of Submission
            $message->subject("A Pelikulove user has commented on your thread " . $thread->title . "")
                ->greeting('Hi ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
                ->line("Pelikulove user  <strong>" . $sender->name . 
                "</strong> has commented on your Thread <a href=" . $url . "><strong>" . 
                $thread->title . "</strong></a>.")
                ->line('"' . $post->content . '"')
                ->line('Click <a href=' . $url . '>here</a> to checkout your Thread!')
                ->line('<br>')
                ->line('<small>To stop recieving Tambayan Forum emails, Click <a href=' . url('profile/xe/edit/notif') . '>here</a>.</small>');

                // profile/xe/edit/notif

            return $message;
        } else {
            $message->subject("A Pelikulove user has commented on thread " . $thread->title . "")
                ->greeting('Hi ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
                ->line("Pelikulove user  <strong>" . $sender->name . 
                "</strong> has commented on Thread <a href=" . $url . "><strong>" . 
                $thread->title . "</strong></a>.")
                ->line('"' . $post->content . '"')
                ->line('Click <a href=' . $url . '>here</a> to checkout the Thread!')
                ->line('<br>')
                ->line('<small>To stop recieving Tambayan Forum emails, Click <a href=' . url('profile/xe/edit/notif') . '>here</a>.</small>');

            return $message;
        }
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
        $thread = $this->thread;
        $post_id = $this->post_id;

        if ($thread->author_id == $notifiable->id) {
            // If User is the Author of Submission
            return [
                'data' => "User <strong>" . $sender->name . "</strong> has commented on your <strong>" 
                . $thread->title . "</strong>!",
                'url' => $url,
                'type' => $type,
                'thread_id' => $thread->id,
                'sender_id' => $sender->id,
                'post_id' => $post_id,
            ];
        } else {
            return [
                'data' => "User <strong>" . $sender->name . "</strong> has commented on thread <strong>" 
                . $thread->title . "</strong>!",
                'url' => $url,
                'type' => $type,
                'thread_id' => $thread->id,
                'sender_id' => $sender->id,
                'post_id' => $post_id,
            ];
        }
    }
}
