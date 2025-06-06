<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentRegistered extends Mailable
{
    use Queueable, SerializesModels;

    /** @var \App\Models\Student */
    public $student;

    /**
     * Vytvoří novou instanci mailu.
     *
     * @param \App\Models\Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * Sestaví mail (view, předávají se data).
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vítej v naší aplikaci!')
            ->view('emails.student-registered')
            // kdybys chtěl, můžeš doplnit ->from('no-reply@mojeapp.cz', 'Moje Appka')
            ;
    }
}
