<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class LikeButton extends Component
{
    public bool $is_trashed = false;

    public bool $set_icon = true;

    public string $likeID = "";

    public Model $model;

    public function countLikes(): int
    {
        return $this->model->likes()->count();
    }

    /**
     * Perform a like to a specific model
     */
    public function toggleLike()
    {    
        $this->model->likes()->toggle(auth()->id());
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
