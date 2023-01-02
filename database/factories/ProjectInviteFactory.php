<?php

namespace Database\Factories;

use App\Enums\ProjectInviteStatusEnum;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectInvite>
 */
class ProjectInviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statusIndex = array_rand(ProjectInviteStatusEnum::cases());

        $status = ProjectInviteStatusEnum::cases()[$statusIndex];

        return [
            'id'         => $this->faker->uuid(),
            'project_id' => Project::factory(),
            'user_id'    => User::factory(),
            'status'     => $status->value,
        ];
    }
}
