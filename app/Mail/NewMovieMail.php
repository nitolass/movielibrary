<?php
namespace App\Mail;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewMovieMail extends Mailable
{
    use Queueable, SerializesModels;

    public $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function build()
    {
        return $this->subject('¡Estreno! Nueva película: ' . $this->movie->title)
            ->view('emails.new_movie'); // Asegúrate de crear resources/views/emails/new_movie.blade.php
    }
}
