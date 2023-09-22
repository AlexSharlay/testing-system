<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $question = $this->addQuestion('1 + 1 =');
        $manager->persist($question);

        $answer = $this->setAnswer('3', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('2', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('0', false, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('2 + 2 =');
        $manager->persist($question);

        $answer = $this->setAnswer('4', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('3 + 1', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('10', false, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('3 + 3 =');
        $manager->persist($question);

        $answer = $this->setAnswer('1 + 5', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('1', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('6', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('2 + 4', true, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('4 + 4 =');
        $manager->persist($question);

        $answer = $this->setAnswer('8', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('4', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('0', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('0 + 8', true, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('5 + 5 =');
        $manager->persist($question);

        $answer = $this->setAnswer('6', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('18', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('10', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('9', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('0', false, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('6 + 6 =');
        $manager->persist($question);

        $answer = $this->setAnswer('3', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('9', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('0', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('12', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('5 + 7', true, $question);
        $manager->persist($answer);




        $question = $this->addQuestion('7 + 7 =');
        $manager->persist($question);

        $answer = $this->setAnswer('5', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('14', true, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('8 + 8 =');
        $manager->persist($question);

        $answer = $this->setAnswer('16', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('12', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('9', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('5', false, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('9 + 9 =');
        $manager->persist($question);

        $answer = $this->setAnswer('18', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('9', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('17 + 1', true, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('2 + 16', true, $question);
        $manager->persist($answer);



        $question = $this->addQuestion('10 + 10 =');
        $manager->persist($question);

        $answer = $this->setAnswer('0', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('2', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('8', false, $question);
        $manager->persist($answer);

        $answer = $this->setAnswer('20', true, $question);
        $manager->persist($answer);

        $manager->flush();
    }

    /**
     * @param string $title
     * @return Question
     */
    private function addQuestion(string $title):Question
    {
        $question = new Question();
        $question->setTitle($title);

        return $question;
    }

    /**
     * @param string $text
     * @param bool $valid
     * @param Question $question
     * @return Answer
     */
    private function setAnswer(string $text, bool $valid, Question $question):Answer
    {
        $answer = new Answer();
        $answer->setAnswer($text);
        $answer->setQuestion($question);
        $answer->setValid($valid);

        return $answer;
    }
}
