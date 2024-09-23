<?php declare(strict_types=1);

namespace App\Enums;

use App\Services\NewsOrg;
use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class SourceEnum extends Enum
{
    // Define the source of news
    const GuardianNews = "The Guardian News";
    const NewYourTimes = "New York Times";
    const NewsOrg = "News Org";


    // Define the source UUID
    const GuardianUUID = "guardian-news";
    const NewYorkTimesUUID = "new-york-times";
    const NewsOrgUUID = "news-org";
}
