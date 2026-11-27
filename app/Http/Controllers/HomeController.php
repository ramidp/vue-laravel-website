<?php

namespace App\Http\Controllers;

use App\Models\ClientLogo;
use App\Models\DemoReel;
use App\Models\EmailShot;
use App\Models\JourneyStep;
use App\Models\Platform;
use App\Models\ServiceGroup;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\WorkItem;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * Show the homepage with data from the database.
     * Inertia::render() sends the props to resources/js/pages/Home.vue
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
            'testimonials' => Testimonial::visible()
                ->get()
                ->map(fn (Testimonial $item) => [
                    'id' => $item->id,
                    'name' => $item->name,
                    'role' => $item->role,
                    'quote' => $item->quote,
                    'photo' => asset($item->photo),
                    'photoPosition' => $item->photo_position,
                    'logo' => [
                        'src' => asset($item->logo),
                        'alt' => $item->logo_alt,
                        'width' => $item->logo_width,
                        'height' => $item->logo_height,
                        'blend' => $item->logo_blend,
                        'crop' => $item->logo_crop,
                    ],
                ]),
            'teamMembers' => TeamMember::visible()
                ->get()
                ->filter(fn (TeamMember $member) => filled($member->photo))
                ->map(fn (TeamMember $member) => [
                    'id' => $member->id,
                    'name' => $member->name,
                    'photo' => asset($member->photo),
                ])
                ->values(),
            'clientLogos' => ClientLogo::visible()
                ->get()
                ->map(fn (ClientLogo $logo) => [
                    'src' => asset($logo->image),
                    'alt' => $logo->alt ?: 'Client logo',
                ]),
            'workRowA' => $this->workUrls(1),
            'workRowB' => $this->workUrls(2),
            'services' => ServiceGroup::visible()
                ->with('items')
                ->get()
                ->map(function (ServiceGroup $group) {
                    $columns = [1 => [], 2 => []];

                    foreach ($group->items as $item) {
                        $columns[$item->column === 2 ? 2 : 1][] = $item->name;
                    }

                    $count = $group->items->count();

                    return [
                        'id' => $group->id,
                        'number' => $group->number,
                        'line1' => $group->line1,
                        'line2' => $group->line2,
                        'count' => $count.' '.Str::plural('service', $count),
                        'text' => $group->text,
                        'columns' => array_values($columns),
                    ];
                }),
            'journey' => JourneyStep::visible()
                ->get()
                ->map(fn (JourneyStep $step) => [
                    'number' => $step->number,
                    'label' => $step->label,
                    'image' => asset($step->image),
                    'title' => $step->title,
                    'text' => $step->body,
                ]),
            'platforms' => $this->platformRows(),
            'emailShots' => EmailShot::visible()
                ->get()
                ->map(fn (EmailShot $shot) => [
                    'src' => asset($shot->image),
                    'wide' => $shot->is_wide,
                    'dim' => $shot->is_dim,
                ]),
            'demoReel' => ($reel = DemoReel::current()->first())
                ? [
                    'desktop' => filled($reel->video) ? asset($reel->video) : null,
                    'mobile' => filled($reel->video_mobile) ? asset($reel->video_mobile) : null,
                ]
                : null,
        ]);
    }

    /**
     * Image URLs for one work marquee row.
     *
     * @return array<int, string>
     */
    private function workUrls(int $row): array
    {
        return WorkItem::visible()
            ->where('row', $row)
            ->get()
            ->map(fn (WorkItem $item) => asset($item->image))
            ->values()
            ->all();
    }

    /**
     * Platform logos grouped into the rows a client chose.
     * An empty row is left out. Row 2 keeps the spread layout.
     *
     * @return array<int, array{row: int, logos: array<int, array{src: string, alt: string}>}>
     */
    private function platformRows(): array
    {
        $grouped = Platform::visible()->get()->groupBy('row');

        return collect([1, 2])
            ->map(function (int $row) use ($grouped) {
                $logos = $grouped->get($row, collect())
                    ->map(fn (Platform $logo) => [
                        'src' => asset($logo->image),
                        'alt' => $logo->alt ?? '',
                    ])
                    ->values();

                return [
                    'row' => $row,
                    'logos' => $logos->all(),
                ];
            })
            ->filter(fn (array $group) => $group['logos'] !== [])
            ->values()
            ->all();
    }
}
