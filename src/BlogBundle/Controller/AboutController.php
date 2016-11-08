<?php
namespace BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
class AboutController extends Controller
{
    public function AboutAction () {
        return $this->render("BlogBundle:Pages:about.html.twig");
    }
}