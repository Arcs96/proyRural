<?php

namespace RuralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use RuralBundle\Entity\Alojamiento;
use TiendaBundle\Form\AlojamientoType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

  /**
   * @Route("/home_rural", name="rural")
   */
  public function indexAction()
  {
      return $this->render('RuralBundle:Default:index.html.twig');
  }

  /**
   * @Route("/prueba", name="prueba")
   */
  public function pruebaAction()
  {
      return $this->render('RuralBundle:Default:index.html.twig');
  }

  /**
   * @Route("/comarca", name="comarca")
   */
  public function comarcaAction()
  {
      $repository = $this->getDoctrine()->getRepository('RuralBundle:Alojamiento');
      $alojamiento = $repository->findAll();

      return $this->render('RuralBundle:Default:comarca.html.twig',array("alojamientos"=>$alojamiento));
  }

  /**
   * @Route("/forminsert", name="forminsert")
   */
  public function formAction(Request $request)
  {
      $alojamiento = new Alojamiento();
      $form = $this->createForm(AlojamientoType::class);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $alojamiento = $form->getData();

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        $em = $this->getDoctrine()->getManager();
        $em->persist($alojamiento);
        $em->flush();

        return $this->redirectToRoute('comarca');
    }
    return $this->render('RuralBundle:Default:form.html.twig',array("form"=>$form->createView()));
  }

  /**
   * @Route("/formupdate/{id}", name="formupdate")
   */
  public function formUpdateAction(Request $request,$id)
  {
      $alojamiento = $this->getDoctrine()->getRepository('RuralBundle:Alojamiento')->find($id);

      $form = $this->createForm(AlojamientoType::class,$alojamiento);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();
        $em->persist($alojamiento);
        $em->flush();
        return $this->redirectToRoute('comarca');
      }
      return $this->render('RuralBundle:Default:form.html.twig',array("form"=>$form->createView()));
  }

    /**
     * @Route("/formdelete/{id}", name="formdelete")
     */
  public function editAction(Request $request, $id)
  {

       $em = $this->getDoctrine()->getManager();
       $user = $em->getRepository("RuralBundle:Alojamiento")->find($id);

       if(!$user){throw $this->createNotFoundException("El usuario con id $id no existe");}

       $editForm = $this->createForm(AlojamientoType::class, $user);
       $editForm->remove('nomAlojamiento');
   }

  /**
   * @Route("/alojamiento", name="alojamiento")
   */
  public function alojamientoAction()
  {
    /* Esta acción en un futuro nos mostrará los detallas de cada alojamiento */
      //return $this->render('RuralBundle:Default:alojamiento.html.twig');
  }

}
