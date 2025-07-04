<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PressRelease;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PressReleaseSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\PressReleaseHistory::truncate();
        \App\Models\PressRelease::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $user = User::first(); // Use the first user
        if (!$user) {
            throw new \Exception('No users found. Please seed users first.');
        }

        $statuses = ['draft', 'published', 'archived'];

        $titles = [
            'Tech Company Launches Revolutionary AI Platform',
            'Global Business Summit Announces 2024 Conference',
            'New Sustainable Energy Initiative Takes Off',
            'Healthcare Provider Expands Services Nationwide',
            'E-commerce Platform Reaches 1 Million Users',
            'Educational Institution Opens New Campus',
            'Financial Services Firm Announces Major Acquisition',
            'Environmental Organization Launches Conservation Program',
            'Tech Startup Secures Series A Funding',
            'Retail Chain Announces Nationwide Expansion',
            'Manufacturing Company Unveils Green Initiative',
            'Digital Marketing Agency Wins Industry Award',
            'Healthcare Tech Company Launches New App',
            'Real Estate Developer Announces Mega Project',
            'Food Delivery Service Expands to New Markets',
            'Automotive Company Unveils Electric Vehicle Line',
            'Software Company Releases Major Update',
            'Construction Firm Wins Government Contract',
            'Media Company Launches New Streaming Service',
            'Pharmaceutical Company Announces Breakthrough'
        ];

        $contents = [
            '<p>In a groundbreaking announcement, the company revealed its latest AI platform that promises to revolutionize how businesses handle data analytics. The new system incorporates advanced machine learning algorithms and natural language processing capabilities.</p><p>Key features include real-time data analysis, predictive modeling, and automated reporting systems.</p>',
            '<p>The annual Global Business Summit will bring together industry leaders from around the world to discuss emerging trends and opportunities in the global marketplace. The event will feature keynote speakers, panel discussions, and networking opportunities.</p>',
            '<p>A new initiative focused on sustainable energy solutions has been launched, aiming to reduce carbon emissions and promote renewable energy adoption. The program includes partnerships with leading research institutions and industry stakeholders.</p>',
            '<p>The healthcare provider has announced plans to expand its services across the country, bringing quality healthcare to more communities. The expansion includes new facilities, specialized treatment centers, and telemedicine services.</p>',
            '<p>The e-commerce platform has reached a significant milestone, serving over 1 million active users. This achievement comes with the introduction of new features and improved user experience.</p>',
            '<p>A new state-of-the-art campus has been opened, featuring modern facilities, advanced learning technologies, and sustainable design elements. The campus will serve thousands of students across various disciplines.</p>',
            '<p>In a strategic move, the financial services firm has completed a major acquisition, expanding its market presence and service offerings. The deal represents a significant step in the company\'s growth strategy.</p>',
            '<p>A new conservation program has been launched to protect endangered species and their habitats. The initiative includes research, community engagement, and sustainable development projects.</p>',
            '<p>The tech startup has successfully secured Series A funding, enabling further development of its innovative products and market expansion. The investment will support hiring and research initiatives.</p>',
            '<p>The retail chain has announced plans for nationwide expansion, opening new locations and creating thousands of jobs. The expansion includes both physical stores and enhanced online presence.</p>',
            '<p>A comprehensive green initiative has been unveiled, focusing on sustainable manufacturing practices and reduced environmental impact. The program includes energy efficiency measures and waste reduction strategies.</p>',
            '<p>The digital marketing agency has been recognized for its innovative campaigns and outstanding client results. The award highlights the agency\'s commitment to excellence and creativity.</p>',
            '<p>A new healthcare app has been launched, offering features for patient monitoring, appointment scheduling, and health record management. The app aims to improve healthcare accessibility and efficiency.</p>',
            '<p>A major real estate development project has been announced, featuring residential, commercial, and recreational spaces. The project will create a sustainable community with modern amenities.</p>',
            '<p>The food delivery service is expanding to new markets, bringing its platform to more cities and regions. The expansion includes partnerships with local restaurants and improved delivery options.</p>',
            '<p>A new line of electric vehicles has been unveiled, featuring advanced technology and sustainable design. The vehicles represent the company\'s commitment to environmental responsibility.</p>',
            '<p>A major software update has been released, introducing new features and improvements to enhance user experience and performance. The update includes security enhancements and new functionality.</p>',
            '<p>The construction firm has been awarded a significant government contract for infrastructure development. The project will create jobs and improve local infrastructure.</p>',
            '<p>A new streaming service has been launched, offering exclusive content and original programming. The service features advanced streaming technology and personalized recommendations.</p>',
            '<p>A breakthrough in pharmaceutical research has been announced, potentially leading to new treatments for serious medical conditions. The development represents years of research and testing.</p>'
        ];

        foreach (range(0, 19) as $i) {
            $status = $i < 12 ? 'published' : $statuses[array_rand($statuses)];
            $publishedAt = $status === 'published' ? now()->subDays(rand(1, 30)) : null;

            PressRelease::create([
                'title' => $titles[$i],
                'slug' => Str::slug($titles[$i]) . '-' . Str::random(5),
                'content' => $contents[$i],
                'status' => $status,
                'published_at' => $publishedAt,
                'user_id' => $user->id,
            ]);
        }
    }
}
