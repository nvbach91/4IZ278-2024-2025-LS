<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentLogin extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Student */
    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this
            ->subject('Login information')
            ->view('emails.student-login');
    }
}
