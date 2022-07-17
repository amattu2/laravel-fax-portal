<?php

namespace App\Notifications;

use App\Models\Fax;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FaxReceived extends Notification
{
  use Queueable;

  private Fax $fax;

  /**
   * Create a new notification instance.
   *
   * @param Fax $fax
   * @return void
   */
  public function __construct(Fax $fax)
  {
    $this->fax = $fax;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['mail'];
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
      ->subject("New Fax From {$this->fax->from}")
      ->greeting("Hello!")
      ->line(__("messages.fax.received", [
        "from" => $this->fax->from,
        "to" => $this->fax->to,
        "when" => $this->fax->created_at,
      ]))
      ->line("The fax is attached to this email.")
      ->attachData(base64_decode($this->fax->content), "fax.pdf");
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [];
  }
}
