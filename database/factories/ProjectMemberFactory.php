<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectInvite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectMember>
 */
class ProjectMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory(),
            'project_id' => Project::factory(),
            'invite_id'  => ProjectInvite::factory(),
        ];
    }
}
