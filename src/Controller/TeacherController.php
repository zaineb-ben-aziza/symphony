<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher/{name}', name: 'app_teacher')]
   
    public function showTeacher($name)
    {
        return $this->render('teacher/showTeacher.html.twig', [
            'name' => $name,
        ]);
    }
    #[Route('/redirecttostudent', name: 'redirect_to_student')]
    public function RedirectToStudent()
    {
        return $this->redirectToRoute('app_student');
    }
    }
