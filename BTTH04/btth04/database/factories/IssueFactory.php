<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Computer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Issue>
 */
class IssueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Lấy ngẫu nhiên id của một máy tính đã tạo [cite: 10]
            'computer_id' => Computer::inRandomOrder()->first()->id ?? Computer::factory(),
            'reported_by' => $this->faker->name(),
            'reported_date' => $this->faker->dateTimeBetween('-1 month', 'now'), // Sự cố trong 1 tháng gần đây
            'description' => $this->faker->paragraph(2), // Mô tả dài khoảng 2 câu
            // Enum theo đúng yêu cầu đề bài [cite: 14]
            'urgency' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            // Enum theo đúng yêu cầu đề bài [cite: 15]
            'status' => $this->faker->randomElement(['Open', 'In Progress', 'Resolved']),
        ];
    }
}
