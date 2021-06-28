<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailSender extends Mailable
{
    use Queueable, SerializesModels;

    public $view;
    public $subject;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(String $view, String $subject,$data = [])
    {
        $this->view = $view;
        $this->subject = $subject;
        if(count($data) > 0){
            $this->data = $data;
        }else{
            $this->data = [];
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('project@alamraya.club', 'Admin Project')
                        ->view($this->view)
                        ->subject($this->subject)
                        ->with(
                        [
                            'nama' => 'Admin Project',
                            'subject' => $this->subject,
                            'data' => $this->data,
                        ]);
    }
}
