<?php

namespace App\Mail;

use App\Models\PlanInvitations;
use App\Models\plans;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $plan;
    public $invitation;
    public $inviterName;
    /**
     * Create a new message instance.
     */
    public function __construct(plans $plan, PlanInvitations $invitation, $inviterName)
    {
        $this->plan = $plan;
        $this->invitation = $invitation;
        $this->inviterName = $inviterName;
    }

    public function build()
    {
        return $this->subject('Invitación a ' . $this->plan->name)
            ->view('emails.plan-invitation');
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Plan Invitation Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
