<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use App\Models\Ticket;


class UpdateTicket extends Notification
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
        $description = Ticket::where('description', '!=', null)->orderBy('updated_at','DESC')->first();
        $assignee = Ticket::where('assignee', '!=', null)->orderBy('updated_at','DESC')->first();
        $priority = Ticket::where('priority', '!=', null)->orderBy('updated_at','DESC')->first();
        $category = Ticket::where('category', '!=', null)->orderBy('updated_at','DESC')->first();
        $creator = Ticket::where('name', '!=', null)->orderBy('updated_at','DESC')->first();
        $creatoremail = Ticket::where('email', '!=', null)->orderBy('updated_at','DESC')->first();
        $created = Ticket::where('created_at', '!=', null)->orderBy('updated_at','DESC')->first();
        $update = Ticket::where('updated_at', '!=', null)->orderBy('updated_at','DESC')->first();
        $status =  Ticket::where('status', '!=', null)->orderBy('updated_at','DESC')->first();
        $id =  Ticket::where('id', '!=', null)->orderBy('updated_at','DESC')->first();

        return (new MailMessage)

            ->line($creator->name)
            ->line('The ticket has been updated. Below is the details of the ticket.')
            ->line('Please click on the Ticket Page button for further details')
            ->line('---------------------------------------------------------------------------')
            ->line('Name: '.$creator->name)
            ->line('---------------------------------------------------------------------------')
            ->line('ID: '.$id->id)
            ->line('---------------------------------------------------------------------------')
            ->line('Email: '.$creatoremail->email)
            ->line('---------------------------------------------------------------------------')
            ->line('Updated at: '.$update->updated_at)
            ->line('---------------------------------------------------------------------------')
            ->line('Description: '.$description->description)
            ->line('---------------------------------------------------------------------------')
            ->line('Priority: '.$priority->priority)
            ->line('---------------------------------------------------------------------------')
            ->line('Assignee: '.$assignee->assignee)
            ->line('---------------------------------------------------------------------------')
            ->line('Category: '.$category->category)
            ->line('---------------------------------------------------------------------------')
            ->line('Status: '.$status->status)
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

            'updated_at'=> $this->ticket->updated_at,

            'assignee'=> $this->ticket->assignee,

            'status'=> $this->ticket->status,

            'id'=> $this->ticket->id

        ];
    }
}
