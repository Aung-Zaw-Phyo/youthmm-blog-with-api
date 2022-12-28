<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory();
        return [
            'body' => $this->faker->paragraph(),
            'blog_id' => Blog::factory(),
            'user_id' => $user,
            'reg_id' => $user,
            'token' => Str::random(10)
        ];
    }
}
