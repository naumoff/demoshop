<?php

use Illuminate\Database\Seeder;

class InquirersTableSeeder extends Seeder
{
    private $inquirersQtyLimit = 35;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($qty=0; $qty<$this->inquirersQtyLimit; $qty++){
            if($qty===0){
                $inquirerId = factory(\App\Inquirer::class)->create(['active'=>1])->id;
            }else{
                $inquirerId = factory(\App\Inquirer::class)->create()->id;
            }
            
            //defining users array
            $usersQty = rand(1,15);
            $usersIds = $this->getRandomUsersArrayIds($usersQty);
            
            //adding questions to inquirer
            $questionsQtyLimit = rand(1,5);
            
            for($questions=0; $questions<$questionsQtyLimit; $questions++){
                //creating questions for inquirer
                $questionId = factory(\App\Question::class)->create([
                    'inquirer_id'=>$inquirerId
                ])->id;
                //adding answers to each question from predefined users
                $this->answerToQuestion($questionId, $usersIds);
            }
        }
    }
    
    private function answerToQuestion(int $questionId, array $userIds)
    {
        foreach($userIds AS $userId){
            factory(\App\QuestionUser::class)->create([
                'user_id'=>$userId,
                'question_id'=>$questionId
            ]);
        }
    }
    
    private function getRandomUsersArrayIds(int $qty)
    {
        $userArrayIds = [];
        for($a=0; $a<$qty; $a++){
            $userIds = \App\User::get(['id']);
            $users = [];
            foreach ($userIds AS $userId) {
                $users[] = $userId->id;
            }
            $userArrayIds[] = \App\User::find($users[rand(0,count($users)-1)]);
        }
        return array_unique($userArrayIds);
    }
}
