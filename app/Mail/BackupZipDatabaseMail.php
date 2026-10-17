<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BackupZipDatabaseMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $zipFilePath;

    /**
     * Create a new message instance.
     */
    public function __construct(string $zipFilePath)
    {
        $this->zipFilePath = $zipFilePath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Backup Database (ZIP) - ' . config('app.name') . ' [' . date('d/m/Y H:i') . ']',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: '
                <p>Halo Admin,</p>
                <p>Terlampir file backup database MySQL terbaru dalam format <b>.zip</b>.</p>
                <p><i>Catatan: Amankan file ini di tempat penyimpanan yang aman.</i></p>
            ',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->zipFilePath),
        ];
    }
}
