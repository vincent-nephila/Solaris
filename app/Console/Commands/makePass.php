<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class makePass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'makepass';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $students = \App\User::where('accesslevel',0)->get();
       
       foreach($students as $student){
           $password = $this->genPass();
           
           $student->password = bcrypt($password);
           $student->save();
           
           $this->saveInfo($student, $password);
           
           $this->info($student->firstname." ".$student->lastname." OK");
       }
    }
    
    function saveInfo($student,$pass){
        $secret = new \App\UserSecret();
        $secret->idno = $student->idno;
        $secret->password = $pass;
        $secret->save();
    }
    
    function genPass(){
         $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
         $string = '';
         $max = strlen($characters) - 1;
         for ($i = 0; $i < 7; $i++) {
              $string .= $characters[mt_rand(0, $max)];
         }
         
         return $string;
    }
}
