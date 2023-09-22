<?php

namespace App\Controller;

use App\Form\TestingForm;
use App\Repository\QuestionRepository;
use App\Service\TestingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['get'])]
    public function index(TestingService $service): Response
    {
        //Список вопросов
        $questions = $service->getQuestions();

        //Перемешать вопросы с ответами
        $service->shuffleQuestions($questions);

        return $this->render('index/index.html.twig', [
            'questions' => $questions
        ]);
    }

    #[Route('/send-result', name: 'app_send_result')]
    public function sendResult(Request $request, TestingService $service):Response
    {
        if (!$this->isCsrfTokenValid('testing_result', $request->request->get('token'))) {
            return $this->redirectToRoute('app_index');
        }

        if(empty($request->request->get('username'))){
            $this->addFlash('error', 'Заполните username');
            return $this->redirectToRoute('app_index');
        }

        $username = $request->request->get('username');
        $answers = $request->request->all('answers');

        //Получить проверенные вопросы
        $verifiedTest = $service->checkTest($answers);

        //Сохранение результата
        $service->saveResult($username, $verifiedTest);

        //Подготовка данных для вывода
        $verifiedTest = $service->prepareResult($verifiedTest);

        return $this->render('index/result.html.twig', [
            'result' => $verifiedTest
        ]);
    }
}
