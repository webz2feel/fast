<?php

namespace Fast\Theme\Events;

use Fast\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RenderingHomePageEvent extends Event
{
    use SerializesModels;
}
