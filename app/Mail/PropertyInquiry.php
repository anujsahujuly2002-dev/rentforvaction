<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PropertyInquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiryData;

    public function __construct(array $inquiryData)
    {
        $this->inquiryData = $inquiryData;
    }

    public function build()
    {
        return $this->subject('New Property Inquiry - ' . $this->inquiryData['property_name'])
                    ->view('email-template.property-inquiry');
    }
}
