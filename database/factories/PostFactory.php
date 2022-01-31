<?php

namespace Database\Factories;

use App\Persistence\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model  = Post::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->makeDescription(),
            'publication_date' => now()->addDays(rand(1, 6))
        ];
    }

    /**
     * Generate description text
     * @return string
     */
    private function makeDescription(): string
    {
        $text = "";
        foreach ($this->faker->paragraphs(rand(5, 8)) as $paragraph) {
            $text .= "<p> $paragraph </p>";
        }
        return $text;
    }
}
