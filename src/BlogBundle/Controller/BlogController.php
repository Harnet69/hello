<?php
namespace BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
class BlogController extends Controller
{
    public function IndexAction(){
        return $this->render('BlogBundle:Blog:blog.html.twig');
    }

    public function CreateAction(){
        return new Response ("добавлено");
    }
}