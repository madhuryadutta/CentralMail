<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class YourMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;

    public $body;

    public $toEmail;

    public $fromEmail;

    public $fromName;

    public $contentType;

    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $toEmail,
        string $subject,
        string $body,
        string $contentType = 'plain',
        ?string $fromEmail = null,
        ?string $fromName = null,
        array $attachments = [], // Accept attachments
    ) {
        $this->toEmail = $toEmail;
        $this->subject = $subject;
        // $this->body = $contentType === 'html' ? $body : $this->convertPlainTextToHtml($body);
        $this->body = $body;
        $this->contentType = 'html'; // Always render as HTML
        $this->fromEmail = $fromEmail ?? config('mail.from.address');
        $this->fromName = $fromName ?? config('mail.from.name');
        $this->attachments = $attachments;
    }

    /**
     * Get the message envelope (To, From, Subject).
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: [new Address($this->toEmail)], // Recipient
            from: new Address($this->fromEmail, $this->fromName), // Sender
            replyTo: [new Address($this->fromEmail, $this->fromName)], // Optional Reply-To
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.template',
            with: [
                'title' => $this->title ?? 'Notification',
                'body' => $this->body,
                'buttonText' => $this->buttonText ?? null,
                'buttonUrl' => $this->buttonUrl ?? null,
            ],
        );
    }
    // public function attachments(): array
    // {
    //     $mailAttachments = [];
    //     foreach ($this->attachments as $file) {
    //         $mailAttachments[] = Attachment::fromPath($file)->withMime(mime_content_type($file));
    //     }
    //     return $mailAttachments;
    //     // var_dump($mailAttachments);die();
    // }

    /**
     * Convert plain text to a simple branded HTML format.
     */
    // protected function convertPlainTextToHtml($content)
    // {
    //     $formattedContent = nl2br(e($content)); // Convert new lines to <br> tags
    //     return "<div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f8f9fa; border: 1px solid #ddd; border-radius: 5px;'>
    //                 <p style='font-size: 16px; color: #333;'>$formattedContent</p>
    //             </div>";
    // }

}
