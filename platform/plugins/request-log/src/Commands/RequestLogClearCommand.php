<?php

namespace Fast\RequestLog\Commands;

use Fast\RequestLog\Repositories\Interfaces\RequestLogInterface;
use Illuminate\Console\Command;

class RequestLogClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:request-logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all request error logs';

    /**
     * @var RequestLogInterface
     */
    protected $requestLogRepository;

    /**
     * RequestLogClearCommand constructor.
     * @param RequestLogInterface $requestLogRepository
     * @author Imran Ali
     */
    public function __construct(RequestLogInterface $requestLogRepository)
    {
        parent::__construct();
        $this->requestLogRepository = $requestLogRepository;
    }

    /**
     * Execute the console command.
     * @author Imran Ali
     * @throws \Throwable
     */
    public function handle()
    {
        $this->info('Processing...');
        $count = $this->requestLogRepository->count();
        $this->requestLogRepository->getModel()->truncate();
        $this->info('Done. Deleted ' . $count . ' records!');

    }
}
