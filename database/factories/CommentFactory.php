<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Story;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=> $this->user->id(),
            'story_id'=>Story::id(),
            'comment'=> $this->Str::random(50),
        ];
    }
}
