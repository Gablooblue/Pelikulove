<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;
use App\Models\ForumPost;
use App\Models\NotifPreferences;

class SendSaluhanSubmissionNotif extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notifData, $sender, $lessonURL, $submissionURL, $fileURL, $submission, $type, $lesson;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notifData)
    {
        $this->sender = $notifData['sender'];   
        $this->lessonURL = $notifData['lessonURL'];
        $this->submissionURL = $notifData['submissionURL'];
        $this->fileURL = $notifData['fileURL']; 
        $this->submission = $notifData['submission']; 
        $this->type = $notifData['type'];
        $this->lesson = $notifData['lesson'];   
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // if (NotifPreferences::getSaluhanEmailPref($notifiable->id) == 1) { 
            return ['database', 'mail'];
        // } else {
        //     return ['database'];
        // }
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
        $lessonURL = $this->lessonURL;
        $submissionURL = $this->submissionURL;
        $fileURL = $this->fileURL;
        $type = $this->type;
        $lesson = $this->lesson;
        $receiver = User::find($notifiable->id);

        $message = new MailMessage();
        $message->subject("Your Pelikulove Student has submitted an entry on " . $lesson->title . "")
            ->greeting('Hi Mentor ' . $receiver->first_name . ' ' . $receiver->last_name . ',')
            ->line("Pelikulove Student  <strong>" . $sender->name . 
            "</strong> has submitted an entry on <a href=" . $lessonURL . "><strong>" . 
            $lesson->title . "</strong></a>.")
            ->line('Click <a href=' . $submissionURL . '>here</a> to checkout the submission!')
            ->line("Attached below is a copy of the submitted file.")
            ->attach($fileURL);

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
        $submissionURL = $this->submissionURL;
        $type = $this->type;
        $lesson = $this->lesson;
        $submission = $this->submission;

        return [
            'data' => "Student <strong>" . $sender->name . "</strong> has submitted an entry on <strong>" 
            . $lesson->title . "</strong>!",
            'url' => $submissionURL,
            'type' => $type,
            'submission_id' => $submission->id,
            'sender_id' => $sender->id,
        ];
    }
}
