<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyInquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiryData;

    public function __construct(array $inquiryData)
    {
        $this->inquiryData = $inquiryData;
    }

    public function build()
    {
        return $this->subject('Your Inquiry for ' . $this->inquiryData['property_name'] . ' - Confirmation')
                    ->view('email-template.property-inquiry-confirmation');
    }
}
