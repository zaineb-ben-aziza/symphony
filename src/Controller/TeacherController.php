<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    /**
     * @Route("/teacher/{name}", name="teacher_show")
     */
    public function showTeacher($name)
    {
        return $this->render('teacher/show.html.twig', [ 'name' => $name, ] );
           
       
    }
    public function goToIndex()
    {
        return $this->redirectToRoute('student_index');
    }
    }
