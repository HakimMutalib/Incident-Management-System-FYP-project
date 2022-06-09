<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use App\Models\Ticket;

class AdminTicketMake extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $description = Ticket::where('description', '!=', null)->orderBy('created_at','DESC')->first();
        $assignee = Ticket::where('assignee', '!=', null)->orderBy('created_at','DESC')->first();
        $priority = Ticket::where('priority', '!=', null)->orderBy('created_at','DESC')->first();
        $category = Ticket::where('category', '!=', null)->orderBy('created_at','DESC')->first();
        $creator = Ticket::where('name', '!=', null)->orderBy('created_at','DESC')->first();
        $creatoremail = Ticket::where('email', '!=', null)->orderBy('created_at','DESC')->first();
        $created = Ticket::where('created_at', '!=', null)->orderBy('created_at','DESC')->first();
        $status =  Ticket::where('status', '!=', null)->orderBy('created_at','DESC')->first();
        $id =  Ticket::where('id', '!=', null)->orderBy('created_at','DESC')->first();

        return (new MailMessage)

            ->line('New incident has been created!')
            ->line('Below is the details of the ticket')
            ->line('Please click on the Ticket Page button for further details')
            ->line('---------------------------------------------------------------------------')
            ->line('Name: '.$creator->name)
            ->line('---------------------------------------------------------------------------')
            ->line('Name: '.$id->id)
            ->line('---------------------------------------------------------------------------')
            ->line('Email: '.$creatoremail->email)
            ->line('---------------------------------------------------------------------------')
            ->line('Created at: '.$created->created_at)
            ->line('---------------------------------------------------------------------------')
            ->line('Description: '.$description->description)
            ->line('---------------------------------------------------------------------------')
            ->line('Priority: '.$priority->priority)
            ->line('---------------------------------------------------------------------------')
            ->line('Category: '.$category->category)
            ->line('---------------------------------------------------------------------------')
            ->action('Notification Action', url('/tickets/ticket'));
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
            'name' => $this->ticket->name,

            'email'=> $this->ticket->email,

            'priority'=> $this->ticket->priority,

            'created_at'=> $this->ticket->created_at,

            'id'=> $this->ticket->id
        ];
    }
}
