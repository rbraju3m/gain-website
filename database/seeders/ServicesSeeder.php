<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title'    => 'The golden standard for assessing nutrition at workplaces',
                'category' => 'Self-Assessment Scorecard',
                'summary'  => 'Free self-assessment tools that empower organisations to evaluate and enhance their workforce nutrition initiatives across multiple worksites and regions.',
                'body'     => <<<'HTML'
<p>The journey to creating effective and impactful workforce nutrition programs begins with a self-assessment of your current efforts. Our free self-assessment tools empower organizations to evaluate and enhance their workforce nutrition initiatives, offering an organization-wide overview across multiple worksites and regions.</p>

<p>The Workforce Nutrition Alliance has developed two self-assessment scorecards:</p>

<ol>
    <li><strong>Workforce Nutrition Scorecard for Formal Settings:</strong> This scorecard enables employers and organizations to assess the nutrition programs they provide to workers in formal worksite settings (physical environments where programs can be implemented).</li>
    <li><strong>Workforce Nutrition Scorecard for Smallholder Farmer Settings:</strong> The Smallholder Farmer Scorecard is designed to help organizations that engage with workforces without regular worksite structure or location to assess their workforce nutrition programs. These workforces tend not to be employees but informal or indirect workers of off-takers, traders, other buyers operating on behalf of larger companies, and uncontracted smallholder farmers. These programs may also extend to their communities or household members.</li>
</ol>

<p>Each scorecard evaluates workforce nutrition programs across four key areas: <strong>Healthy Food At Work, Nutrition Education, Nutrition-Focused Health Checks, and Breastfeeding Support.</strong> For a detailed assessment of the Healthy Food At Work components of the scorecard for formal settings, region-specific Healthy Food Checklists are available to help you assess and enhance workplace nutrition.</p>

<p>Please download the pre-read documents, which include the Terms &amp; Conditions, Data Disclaimer, and paper versions of each scorecard. Additionally, download the region-specific Healthy Food Checklist that best suits your worksites.</p>
HTML,
                'url'      => 'https://workforcenutrition.org/en-rs/self-assessment-scorecard/',
            ],
            [
                'title'    => 'Get your free copy of our guidebook series',
                'category' => 'Guidebook Series',
                'summary'  => 'Free downloadable guidebooks with simple steps your organisation can take to implement an effective workforce nutrition programme.',
                'body'     => <<<'HTML'
<p>Our guidebooks are free to download and offer simple steps your organization can take to implement an effective workforce nutrition programme. There is a guidebook for each of our workforce nutrition themes: <strong>Healthy food at work, Nutrition education, Breastfeeding support, and Nutrition health checks.</strong> These guides are especially useful for organisations with limited resources.</p>

<p>These guidebooks are developed to support organisations working with workers in 2 different worksite structures:</p>

<ol>
    <li>Formal worksite settings (physical environments where programs can be implemented);</li>
    <li>Worksite without a regular traditional structure, such as the smallholder farmers.</li>
</ol>

<p>Organisations can download the guidebooks below that best fit the worksite structures they are operating in.</p>

<p>On the other hand, mental health problems are recognised as a major global challenge primarily affecting the workforce. In our latest publication, we show the connection between mental health and nutrition and provide practical pathways for organisations to integrate nutrition into their existing mental health programmes.</p>
HTML,
                'url'      => 'https://workforcenutrition.org/en-rs/guidebook-series/',
            ],
        ];

        foreach ($items as $i => $item) {
            $existing = Service::where('title', $item['title'])->first();

            $data = array_merge($item, [
                'sort_order'   => $i + 1,
                'is_published' => true,
            ]);

            if ($existing) {
                $existing->update($data);
            } else {
                Service::create(array_merge($data, [
                    'slug' => Service::generateSlug($item['title']),
                ]));
            }
        }
    }
}
