<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class UserReviews extends Component
{
    use WithPagination;

    public $review_id;
    public $rating;
    public $content;
    public $isEditing = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'required|string|max:1000',
    ];

    public function render()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with('movie')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('livewire.user-reviews', ['reviews' => $reviews], [
            'reviews' => $reviews
        ])->layout('layouts.app');
    }

    public function edit($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);

        $this->review_id = $id;
        $this->rating = $review->rating;
        $this->content = $review->content;
        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        $review = Review::where('user_id', Auth::id())->findOrFail($this->review_id);

        $review->update([
            'rating' => $this->rating,
            'content' => $this->content,
        ]);

        $this->reset(['rating', 'content', 'review_id', 'isEditing']);
        session()->flash('message', 'Reseña actualizada correctamente.');
    }

    public function cancel()
    {
        $this->reset(['rating', 'content', 'review_id', 'isEditing']);
    }

    public function delete($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        $review->delete();
        session()->flash('message', 'Reseña eliminada.');
    }
}
