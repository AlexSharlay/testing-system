<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Question;
use App\Entity\Result;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;

class TestingService
{
    private QuestionRepository $questionRepository;
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        $this->questionRepository = $em->getRepository(Question::class);
    }

    /**
     * Список вопросов с ответами
     *
     * @return float|int|mixed[]|string
     */
    public function getQuestions()
    {
        return $this->questionRepository->getQuestions();
    }

    /**
     * Перемешать ответы и вопросы
     *
     * @param array $questions
     * @return void
     */
    public function shuffleQuestions (array &$questions): void
    {
        shuffle($questions);

        foreach ($questions as &$question){
           shuffle($question['answers']);
        }
    }

    /**
     * Проверка вопросов
     *
     * @param array $answers
     * @return array
     */
    public function checkTest(array $answers): array
    {
        $questions = $this->getQuestions();

        //в массив записываются проверенные вопросы
        $testResult = [];

        foreach ($questions as $question)
        {

            /** @var array $answerToQuestion проверенный вопрос, в конце цикла добавляется в $testResult
             изначально присваивается вопрос из бд */
            $answerToQuestion = $question;
            //Флаг указывает, что ответ на вопрос верный
            $answerToQuestion['correct_answer'] = true;

            //Если в ответах нет вопроса из бд или нет ответов на вопрос, то вопрос не засчитывается
            // и выполняется переход на следующую итерацию
            if (!isset($answers[$question['id']]) && !empty($answers[$question['id']]['answer'])){
                $answerToQuestion['correct_answer'] = false;
                $testResult[] = $answerToQuestion;
                continue;
            }

            /** @var array $selectedAnswers список выбранных ответов */
            $selectedAnswers = $answers[$question['id']];

            //В цикле проставляются выбранные пользователем ответы в $answerToQuestion
            //И идет проверка правильности выбранного пользователем ответа
            foreach ($answerToQuestion['answers'] as &$answer){
                if (empty($selectedAnswers[$answer['id']])){
                    $answer['selected'] = false;
                    continue;
                }

                //Выбранный пользователем ответ
                $answer['selected'] = true;
                //Если пользователь выбрал не правильный ответ, то вопрос не засчитывается
                if ($answer['valid'] !== true){
                    $answerToQuestion['correct_answer'] = false;
                }
            }

            //Добавление в массив проверенных вопросов
            $testResult[] = $answerToQuestion;
        }

        return $testResult;
    }

    /**
     * Сохранение проверенного теста в бд
     *
     * @param string $username
     * @param array $resultData
     * @return void
     */
    public function saveResult(string $username, array $resultData): void
    {
        $result = Result::create($username, $resultData);

        $this->em->persist($result);

        $this->em->flush();
    }

    /**
     * Подготовка данных для вывода результата
     *
     * @param array $verifiedTest
     * @return array[]
     */
    public function prepareResult(array $verifiedTest): array
    {
        $valid = [];
        $noValid = [];

        foreach ($verifiedTest as $question)
        {
            if ($question['correct_answer'] === true){
                $valid[] = $question;
            }else{
                $noValid[] = $question;
            }
        }

        return ['valid' => $valid, 'noValid' => $noValid];
    }
}
