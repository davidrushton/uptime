<?php namespace App\Console\Commands;

use Exception;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Psr\Log\LoggerInterface;

class Ping extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping server to check network uptime';

    /**
     * @var LoggerInterface
     */
    private $log;

    public function __construct(LoggerInterface $log)
    {
        parent::__construct();

        $this->log = $log;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $host = 'google.com';
        $port = 80;
        $timeout = 6;

        if ( $this->option('debug') ) {
            $this->log->debug('Checking '.$host.':'.$port);
        }

        try {
            $check = fsockopen($host, $port, $errno, $errstr, $timeout);

            if ( ! $check ) {
                throw new Exception;
            }

        } catch ( Exception $e ) {
            $this->log->alert('Network down '.$e->getMessage());
        }
    }

    public function getOptions()
    {
        return [
            ['debug', null, InputOption::VALUE_NONE, 'Log when checking host']
        ];
    }

}
