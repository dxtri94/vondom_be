<?php

use Illuminate\Database\Seeder;
use App\Models\Newsletter;
class NewsletterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'Call Of Duty - Big Zombies DLC Pack',
                'content' => 'Call of Duty: Black Ops III is getting another piece of DLC based entirely around the series\' 
                              long-running Zombies mode, and now publisher Activision has announced how much the pack will cost.
                              Zombies Chronicles will set you back $30 (with international pricing yet to be announced), 
                              whereas most Call of Duty map packs cost $15. More content is included than in most Call of Duty add-on packs, 
                              however: Chronicles bundles together and remasters eight old Zombies maps from World At War, Black Ops, and Black Ops II.',
                'status' => config('constants.NEWSLETTER_STATUS.HOT_GAME')
            )
        );
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'More Footage Of Forza Horizon 3',
                'content' => 'As part of a livestream event today, Microsoft showed off new gameplay footage from Forza Horizon 3 upcoming Hot Wheels expansion.',
                'status' => config('constants.NEWSLETTER_STATUS.NEWEST_GAME')
            )
        );
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'Steam: Valve Discusses The Challenges',
                'content' => 'With its many thousands of games and more than 125 million users, Steam is a giant the PC gaming space. 
                              Developers use the platform to reach a wide audience, but as Valve acknowledges in a blog post, one of the challenges of Steam as a storefront 
                              is that it "has to serve so many players whose tastes and interests are not only different, but sometimes complete opposites.',
                'status' => config('constants.NEWSLETTER_STATUS.NEWEST_GAME')
            )
        );
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'Overwatch-Like Paladins Not Coming To Nintendo Switch',
                'content' => 'Like Overwatch itself, the game that often gets compared to it--Paladins--is not coming to the Nintendo Switch--at least not yet.
                              Hi-Rez co-founder Todd Harris told DualShockers that a Switch versions of Paladins is not in the works "at this time."
                              The current focus for the studio is on the PC, Xbox One, and PS4 versions. Harris didn provide any further details on why Hi-Rez isn 
                              looking to bring Paladins to Switch at this time.Call of Duty add-on packs, 
                              however: Chronicles bundles together and remasters eight old Zombies maps from World At War, Black Ops, and Black Ops II.',
                'status' => config('constants.NEWSLETTER_STATUS.HOT_GAME')
            )
        );
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'PS4/3DS Dragon Quest 11',
                'content' => 'Square Enix has revealed more details about the battle system in Dragon Quest XI, the upcoming PS4 and 3DS chapter in the long-running RPG franchise',
                'status' => config('constants.NEWSLETTER_STATUS.HOT_GAME')
            )
        );
        Newsletter::create(array(
                'user_id' => 3,
                'title' => 'Saints Row Spinoff Agents Of Mayhem',
                'content' => 'This newest video shows three of the game\'s characters: Hollywood, Fortune, and Hardtack',
                'status' => config('constants.NEWSLETTER_STATUS.HOT_GAME')
            )
        );
    }
}
