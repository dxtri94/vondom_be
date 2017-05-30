<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Confirmation;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Mail;

class SendVerifyEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;
    protected $confirm;

    /**
     *
     * Create a new job instance.
     *
     * SendVerifyEmail constructor.
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
                'name' => config('constants.NAME'),
                'email' => config('constants.EMAILs.INFO')
            );

            $to = array(
                'email' => $this->user->email,
                'name' => $this->user->username || $this->user->surname
            );


            Mail::send('emails.auth.verify-register-email', array(
                'user' => $this->user,
                'link' => config('constants.LINKs.VERIFY_EMAIL') . "/" . $this->confirm->token
            ), function ($message) use ($from, $to) {

                if (!empty($from)) {
                    $message->from($from['email'], $from['name']);
                } else {
                    $message->from(config('constants.EMAILS.EMAIL'), config('constants.EMAILS.NAME'));
                }

                $message->to($to['email'], $to['name'])
                    ->subject(config('constants.EMAILs.SUBJECT.NEW_REGISTER'));
            });

            // send email success
            if (count(Mail::failures()) > 0) {
                return false;
            } else {
                return true;
            }

        } catch (Exception $e) {
            Log::error('send verify email failed: ', $e);
            return false;
        }
    }
}
