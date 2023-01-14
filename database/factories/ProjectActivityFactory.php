<?php

namespace Database\Factories;

use App\Enums\ProjectActivityTypeEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectActivity>
 */
class ProjectActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'user_id'    => User::factory(),
        ];
    }

    public function createProject()
    {
        return $this->state(fn () => ['type' => ProjectActivityTypeEnum::CREATE_PROJECT->value]);
    }
}
