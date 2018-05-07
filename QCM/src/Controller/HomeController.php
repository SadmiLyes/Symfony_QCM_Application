<?php
/**
 * Created by PhpStorm.
 * User: Lyes
 * Date: 5/6/2018
 * Time: 4:51 PM
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home", methods="GET")
     **/
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
}