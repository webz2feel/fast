<?php

namespace Fast\Theme\Events;

use Fast\Base\Events\Event;
use Illuminate\Queue\SerializesModels;

class RenderingSiteMapEvent extends Event
{
    use SerializesModels;
}
