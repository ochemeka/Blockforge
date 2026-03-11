<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->loginUrl = config('app.url') . '/login';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to BlockForge - Start Mining Today!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: [
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'country' => $this->getCountryName($this->user->country),
                'state' => $this->user->state,
                'loginUrl' => $this->loginUrl,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Get country name from code
     */
    private function getCountryName($code)
    {
        $countries = [
            'NG' => 'Nigeria',
            'GH' => 'Ghana',
            'KE' => 'Kenya',
            'ZA' => 'South Africa',
            'EG' => 'Egypt',
            'MA' => 'Morocco',
            'TZ' => 'Tanzania',
            'UG' => 'Uganda',
            'SN' => 'Senegal',
            'CI' => "Cote d'Ivoire",
            'CM' => 'Cameroon',
            'ET' => 'Ethiopia',
            'DZ' => 'Algeria',
            'RW' => 'Rwanda',
            'TN' => 'Tunisia',
            'ML' => 'Mali',
            'BF' => 'Burkina Faso',
            'NE' => 'Niger',
            'ZW' => 'Zimbabwe',
            'ZM' => 'Zambia',
            'MW' => 'Malawi',
            'AO' => 'Angola',
            'MG' => 'Madagascar',
            'MU' => 'Mauritius',
            'SC' => 'Seychelles',
            'CV' => 'Cape Verde',
            'GM' => 'Gambia',
            'GW' => 'Guinea-Bissau',
            'SL' => 'Sierra Leone',
            'LR' => 'Liberia',
            'ST' => 'Sao Tome and Principe',
            'CG' => 'Republic of the Congo',
            'CD' => 'DR Congo',
            'GA' => 'Gabon',
            'GQ' => 'Equatorial Guinea',
            'SZ' => 'Eswatini',
            'LS' => 'Lesotho',
            'NA' => 'Namibia',
            'BW' => 'Botswana',
        ];

        return $countries[$code] ?? $code;
    }
}
