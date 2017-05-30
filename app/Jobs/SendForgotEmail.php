<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Confirmation;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $confirm;

    /**
     *
     * Create a new job instance.
     *
     * SendForgotEmail constructor.
     * @param User $user
     * @param Confirmation $confirm
     */
    public function __construct(User $user, Confirmation $confirm)
    {
        $this->user = $user;
        $this->confirm = $confirm;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $from = array(
                'email' => config('constants.EMAILs.SUPPORT'),
                'name' => config('constants.NAME')
            );
            $to = array(
                'email' => $this->user->email,
                'name' => $this->user->username
            );


            Mail::send('emails.auth.forgot', array(
                'user' => $this->user,
                'link' => config('constants.LINKs.FORGOT') . "/" . $this->confirm->token
            ), function ($message) use ($from, $to) {

                if (!empty($from)) {
                    $message->from($from['email'], $from['name']);
                } else {
                    $message->from(config('constants.EMAILS.EMAIL'), config('constants.EMAILS.NAME'));
                }

                $message->to($to['email'], $to['name'])
                    ->subject(config('constants.EMAILs.SUBJECT.FORGOT'));
            });

            // send email success
            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }

        } catch (Exception $e) {
            Log::error('send forgot password error: ', $e);
            return false;
        }
    }

}
