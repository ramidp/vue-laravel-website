<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Insert the "Madly Ever After" testimonials.
     * Photo and logo paths are relative to public/.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'Richie Francisco',
                'role' => "Creative Strategist,\nNeo Financial",
                'quote' => "MADHUB is an absolute gem.\n\nThe team quickly got up to speed on our Neo’s brand, positioning and products, and delivered creatives with insightful strategy to back it up - which we could’ve easily run on the spot. They’re incredibly responsive and flexible, especially when our plans shift (which they often do). The team also has a “say yes” mentality, but they’re not just yes-people. They push us with new framing, designs, and creative executions that challenge how we typically work, in ways that are worth testing.\n\nI’m looking forward to creating more kick-ass creatives with MADHUB in the future!”",
                'photo' => 'images/709d8.png',
                'logo' => 'images/3e9f7.png',
                'logo_alt' => 'Neo Financial',
                'logo_width' => 99,
                'logo_height' => 37,
            ],
            [
                'name' => 'Steve Gaskin',
                'role' => "Founder, CEO\nRetrokid Inc.",
                'quote' => 'MADHUB is truly MAD! Mad, to always be there when we had no one else to turn to, after hours, even on Holidays, they’ve rescued us time and time again. Mad, to continue accommodating a client (totally us) that’s constantly changing plans at the eleventh hour and sending half-baked ideas, only to see the MH team turn them in to masterpieces. Mad (and a bit crazy), at taking very little direction and brand assets to create emotionally engaging content that’s elevated our customer experience and crushed our expectations. The Madhub team is an invaluable weapon of creativity, strategy, and solutions that we’ve never experienced with any other agency to date. Highly recommend their madness.”',
                'photo' => 'images/119df.png',
                'logo' => 'images/6e4c7.png',
                'logo_alt' => 'Retrokid',
                'logo_width' => 107,
                'logo_height' => 37,
            ],
            [
                'name' => 'Rick Posey',
                'role' => 'Marketing Manager',
                'quote' => 'MADHUB has been a great partner in helping us drive business and increase revenue. Very effective in all of our marketing activities by offering a different point of view on creativity, and their ability to help us drive social media is off the charts. They’re transparent, and they overcommunicate - the value is outstanding for us as a company. If you’re considering changing firms or you want somebody to take a fresh look at your business to help you drive revenue and customer satisfaction, check them out!”',
                'photo' => 'images/bfe02.png',
                'logo' => 'images/3cc39.png',
                'logo_alt' => '13 Fifty Apparel',
                'logo_width' => 61,
                'logo_height' => 37,
            ],
            [
                'name' => 'AJ Silverman',
                'role' => 'VP, Global Marketing & Partnerships - Bioharvest Sciences',
                'quote' => 'We’ve been working with MADHUB for almost 4 years now and what I think sets them apart is that they really lean in to understand our business. I love their ability to strategically think about our priorities, while keeping performance top of mind. It’s really important that communication from both parties is clear, and that the agency you work with understands the entire customer journey—we’ve found that here at MADHUB"',
                'photo' => 'images/f2941.png',
                'logo' => 'images/2330a.png',
                'logo_alt' => 'BioHarvest Sciences',
                'logo_width' => 127,
                'logo_height' => 25,
            ],
            [
                'name' => 'Ryan Holt',
                'role' => "Vice President, Strategy, Sales & Digital\nAccessibility Professionals",
                'quote' => 'We’ve worked with Steve for many, many years, and since the launch of MADHUB we’ve benefited from a broader team and added resources without losing the personal, hands-on support we value. They’re trusted partners who handle complex challenges behind the scenes so we can spend more time with our customers. Technically, they’re in a league of their own and the strongest development team we’ve ever worked with. I recommend them without hesitation.”',
                'photo' => 'images/a909d.png',
                'logo' => 'images/4b3bd.png',
                'logo_alt' => 'Accessibility Professionals',
                'logo_width' => 181,
                'logo_height' => 27,
            ],
            [
                'name' => 'Ronneil Ramlal',
                'role' => "Founder & CEO\nProtein Chefs",
                'quote' => 'We really enjoy working with MADHUB! We share a seamless synergy, aligned in our objectives and vision. MADHUB revamped our branding and took it to the next level! Protein Chefs looks fresh, premium and makes us proud - from our logo to packaging to our uniforms, their team really made a difference. In addition, MADHUB’s meticulous attention to detail ensures that no opportunity is missed and no challenge is too daunting. Their expertise has been invaluable, especially during challenging times like website migration, where they helped maintain strong and steady ad performance. We look forward to continuing collaborating and can’t wait to see what the future holds!”',
                'photo' => 'images/39d9b.png',
                'photo_position' => 'center bottom',
                'logo' => 'images/17103.png',
                'logo_alt' => 'Protein Chefs',
                'logo_width' => 85,
                'logo_height' => 37,
            ],
            [
                'name' => 'Norm Lucas',
                'role' => "Playbook, Project Manager\nKinsmen 50/50 Lottery",
                'quote' => 'When we launched our first 50/50 lottery in Canada, we needed a partner who understood how buyer behaviour shifts throughout a campaign and how to navigate the regulatory landscape with quick but strategic approach. MADHUB delivered that expertise from day one, building compliant, engaging paid and email campaigns with stellar creatives that drove solid performance. The results gave us the confidence to scale our operation and consistently drive sales.”',
                'photo' => 'images/842b4.png',
                'logo' => 'images/728af.png',
                'logo_alt' => 'Kinsmen',
                'logo_width' => 99,
                'logo_height' => 37,
            ],
            [
                'name' => 'Caitlin Wolf',
                'role' => "Director of Marketing & PR\nMade Plus",
                'quote' => 'MADHUB has been an incredible partner to Made Plus over the past year. They handle our digital ads and email strategy end-to-end, and we’ve seen consistent improvement in ROAS, stronger creative, and cleaner conversion tracking as a result. Their team is fast, responsive, and incredibly organized - making it easy for a small team like ours to move quickly. One of our biggest wins together was Black Friday, where we nearly tripled sales year-over-year. I highly recommend MADHUB for startups or emerging brands looking for smart strategy, great creative, and real growth.”',
                'photo' => 'images/e5783.png',
                'logo' => 'images/53790.png',
                'logo_alt' => 'Made Plus',
                'logo_width' => 129,
                'logo_height' => 33,
            ],
            [
                'name' => 'Jamie Railian',
                'role' => "Fundraising Coordinator\nDryden Regional Health Services",
                'quote' => 'MADHUB has been a phenomenal partner in building our 50/50 raffle. Their expertise guided us through a complicated, heavily regulated market, helping us lower acquisition costs and significantly grow the value of our returning supporters. Raffles, lotteries, and foundations should partner with them to reach their full potential."',
                'photo' => 'images/ebe55.png',
                'logo' => 'images/675f1.png',
                'logo_alt' => 'Dryden Regional Health Services',
                'logo_width' => 165,
                'logo_height' => 61,
            ],
            [
                'name' => 'Cam Stager',
                'role' => 'Founder - Kala Therapy',
                'quote' => 'MADHUB consistently delivers exceptional 3D graphic renderings for Kala Therapy’s projects. As the founder of Kala, I always prioritize reaching out to MADHUB first due to their unparalleled quality and professionalism. Having worked with numerous designers in the past, I can confidently say that MADHUB’s team stands out as the best, and collaborating with them is always a pleasure.”',
                'photo' => 'images/5ddf3.png',
                'logo' => 'images/be012.png',
                'logo_alt' => 'Kala Therapy',
                'logo_width' => 131,
                'logo_height' => 33,
            ],
            [
                'name' => 'Daniel Mazour',
                'role' => 'Co-Founder - Coldture Wellness Inc.',
                'quote' => 'When we embarked on the journey to unveil our latest innovation, the Coldture Pro Plunge, we knew we needed to showcase not just its sleek design, but the intricate mechanics and components that set it apart. This is where MADHUB’s exceptional 3D animation services transformed our vision into a captivating reality.”',
                'photo' => 'images/5ab62.png',
                'logo' => 'images/11301.png',
                'logo_alt' => 'Coldture',
                'logo_width' => 132,
                'logo_height' => 33,
                'logo_blend' => 'exclusion',
                'logo_crop' => ['width' => '100%', 'height' => '363.29%', 'left' => '0', 'top' => '-115.55%'],
            ],
            [
                'name' => 'Pascal Cevaer-Corey',
                'role' => 'Pave Finance, Inc. - Founder & President',
                'quote' => 'MADHUB has been instrumental in translating our vision and mission into a cohesive brand identity and marketing strategy. They have been quick to adapt and more than capable of suiting our everchanging needs as an early stage startup. I look forward to working with the MADHUB team for many years to come!”',
                'photo' => 'images/eb97e.png',
                'logo' => 'images/57d8d.png',
                'logo_alt' => 'Pave Finance',
                'logo_width' => 85,
                'logo_height' => 38,
            ],
            [
                'name' => 'Saurabh C.',
                'role' => "Product Manager\nSaint-Gobain",
                'quote' => 'MADHUB turned our vision into reality with creativity, precision, and flawless execution. A truly collaborative team that delivers excellence every time!"',
                'photo' => 'images/a17db.png',
                'photo_position' => 'center bottom',
                'logo' => 'images/982ff.png',
                'logo_alt' => 'Saint-Gobain',
                'logo_width' => 163,
                'logo_height' => 37,
            ],
            [
                'name' => 'Matthew Hall',
                'role' => "Founder\nTrufit Customs",
                'quote' => 'MADHUB has been a really solid partner for us across multiple parts of the business. They brought much-needed structure and clarity to our paid channels, making performance easier to manage as we scaled, and ensuring everything felt more intentional. On the retention side, they strengthened our DTC funnel, and Email is now a dependable channel that drives repeat purchases, increases lifetime value, and creates predictable performance And their creative team, consistently delivers high-polish work, pushing creative boundaries through a thoughtful mix of strong design, 3D modeling, and emerging AI techniques. Overall, it’s been incredible working with the team, and I would highly recommend them.”',
                'photo' => 'images/8d6f6.png',
                'logo' => 'images/da572.png',
                'logo_alt' => 'Trufit Customs',
                'logo_width' => 90,
                'logo_height' => 37,
            ],
            [
                'name' => 'Holly Kaemingh',
                'role' => 'Director of Fundraising at Riverside Health Care Facilities Inc.',
                'quote' => 'Our raffle was already running when MADHUB came on board, and within a few months our draw sales had more than doubled. For a hospital 50/50, that growth turns straight into equipment and care. MADHUB treats the lottery as a year-round program and strategically builds every draw toward steady, recurring support, attracting both new players as well as retaining existing ones. Nobody we’ve worked with understands charitable gaming the way they do.”',
                'photo' => 'images/919e3.png',
                'logo' => 'images/ae070.png',
                'logo_alt' => 'Riverside Health Care',
                'logo_width' => 123,
                'logo_height' => 22,
                'logo_crop' => ['width' => '105.05%', 'height' => '142.74%', 'left' => '-2.51%', 'top' => '-21.59%'],
            ],
        ];

        foreach ($items as $index => $item) {
            Testimonial::create([
                'photo_position' => null,
                'logo_blend' => null,
                'logo_crop' => null,
                ...$item,
                'sort_order' => $index + 1,
            ]);
        }
    }
};
