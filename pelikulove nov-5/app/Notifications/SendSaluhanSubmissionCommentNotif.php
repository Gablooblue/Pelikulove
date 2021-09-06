<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\Lesson;
use App\Models\NotifPreferences;

class SendSaluhanSubmissionCommentNotif extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notifData, $sender, $url, $type, $comment, $submission;

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
        $this->submission = $notifData['submission'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {        
        if (NotifPreferences::getSaluhanEmailPref($notifiable->id) == 1) { 
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
        $submission = $this->submission;
        $receiver = User::find($notifiable->id);
        $lesson = Lesson::find($submission->lesson_id);

        $message = new MailMessage();
        if ($submission->user_id == $notifiable->id) {
            // If User is the Author of Submission
            $message->subject("A Pelikulove user has commented on your submission, " . $submission->title . "")
                ->greeting('Hi Student ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
                ->line("Pelikulove user  <strong>" . $sender->name . "</strong> has commented on your <strong>" . 
                $lesson->title . "</strong> submission, <a href=" . $url . "><strong>" . 
                $submission->title . "</strong></a>.")
                ->line('"' . $comment->body . '"')
                ->line('Click <a href=' . $url . '>here</a> to checkout the comment!')
                ->line('<br>')
                ->line('<small>To stop recieving Saluhan Workspace emails, Click <a href=' . url('profile/xe/edit/notif') . '>here</a>.</small>');
    
            return $message;
        } else {
            $message->subject("A Pelikulove user has commented on the submission, " . $submission->title . "")
                ->greeting('Hi Student ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
                ->line("Pelikulove user  <strong>" . $sender->name . "</strong> has commented on the <strong>" . 
                $lesson->title . "</strong> submission, <a href=" . $url . "><strong>" . 
                $submission->title . "</strong></a>.")
                ->line('"' . $comment->body . '"')
                ->line('Click <a href=' . $url . '>here</a> to checkout the comment!')
                ->line('<br>')
                ->line('<small>To stop recieving Saluhan Workspace emails, Click <a href=' . url('profile/xe/edit/notif') . '>here</a>.</small>');
    
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
        $comment = $this->comment;
        $submission = $this->submission;
        $receiver = User::find($notifiable->id);
        $lesson = Lesson::find($submission->lesson_id);

        if ($submission->user_id == $notifiable->id) {
            // If User is the Author of Submission
            return [
                'data' => "User <strong>" . $sender->name . "</strong> has commented on your <strong>" . 
                $lesson->title . "</strong> submission, <strong>" . $submission->title . "</strong>!",
                'url' => $url,
                'type' => $type,
                'submission_id' => $submission->id,
                'comment_id' => $comment->id,
                'sender_id' => $sender->id,
            ];
        } else {
            return [
                'data' => "User <strong>" . $sender->name . "</strong> has commented on the </strong>" . 
                $lesson->title . "</strong> submission, <strong>" 
                . $submission->title . "</strong>!",
                'url' => $url,
                'type' => $type,
                'submission_id' => $submission->id,
                'comment_id' => $comment->id,
                'sender_id' => $sender->id,
            ];
        }
    }
}
