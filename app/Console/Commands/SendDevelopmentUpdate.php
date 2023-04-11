<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\DevelopmentUpdate;
use Illuminate\Support\Facades\Mail;

class SendDevelopmentUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:devupdate {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a development update to all users on the mailing list.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('user') == 'all') {
            $mailusers = \App\User::where('maillist',1)->get();
            foreach ($mailusers as $key=>$mailuser) {
                $actualkey = $key + 1;
                $this->info($actualkey.': Sending email to: '.$mailuser->email);
                Mail::to($mailuser->email)->send(new DevelopmentUpdate());
            }
        }
        else {
            $mailuser = \App\User::find($this->argument('user'));
            $this->info('1: Sending email to: '.$mailuser->email);
            Mail::to($mailuser->email)->send(new DevelopmentUpdate());
        }
    }
}
