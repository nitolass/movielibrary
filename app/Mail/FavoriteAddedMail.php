<?php
namespace App\Mail;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FavoriteAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $movie;

    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function build()
    {
        return $this->subject(' Nueva película favorita: ' . $this->movie->title)
            ->view('emails.favorite_added'); // (Recuerda crear la vista o usar text('...'))
    }
}
