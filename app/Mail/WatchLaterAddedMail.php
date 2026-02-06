<?php
namespace App\Mail;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WatchLaterAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function build()
    {
        return $this->subject('Guardada para ver más tarde: ' . $this->movie->title)
            ->view('emails.watch_later_added');
    }
}
