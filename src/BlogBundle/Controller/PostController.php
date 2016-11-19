<?php

namespace BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use BlogBundle\Entity\Post;
use BlogBundle\Form\PostType;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Show all Post entities in production.
     *
     */
    public function ProdAction(Request $request)
    {
        $em = $this->getDoctrine();
        $em = $em->getRepository('BlogBundle:Post');
    /*Quantity all posts*/
        $countBlog = $em->findAllBlogCont();
    /*Number of output page. If isset get parameter in URL - add into him "page"*/
        $page = $request->query->get("page")&&  $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $posts = $em->findBlog(["page"=>$page]);
        $pagination = [
            "total" => array_shift($countBlog),
            "page" => $page,
            'max_result' => 3,
            'url' => "create_prod",
        ];
        return $this->render('BlogBundle:post:production.html.twig', array(
            'posts' => $posts,
            'pagination' => $pagination,
        ));
    }

    /**
     *  Show Post entity in production.
     *
     */
    public function ShowPOstAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('BlogBundle:Post');
        $post = $repository->find($id);
        return $this->render('BlogBundle:post:showpost.html.twig', array(
            'post' => $post,
        ));
    }


    /**
     * Lists all Post entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /*Output all blogs per page*/
        //$posts = $em->getRepository('BlogBundle:Post')->findAll();
        /*Quantity all posts*/
        $countBlog = $em->getRepository('BlogBundle:Post')->findAllBlogCont();
        $em = $em->getRepository('BlogBundle:Post');
        //var_dump(array_shift($countBlog));
        /*Number of output page. If isset get parameter in URL - add into him "page"*/
        $page = $request->query->get("page")&&  $request->query->get("page") > 1 ? $request->query->get("page") : 1;
        $posts = $em->findBlog(["page"=>$page]);
        $pagination = [
            "total" => array_shift($countBlog),
            "page" => $page,
            'max_result' => 3,
            'url' => "create_prod",
        ];

        return $this->render('BlogBundle:post:index.html.twig', array(
            'posts' => $posts,
            'pagination' => $pagination
        ));
    }

    /**
     * Creates a new Post entity.
     *
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm('BlogBundle\Form\PostType', $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('create_show', array('id' => $post->getId()));
        }

        return $this->render('BlogBundle:post:new.html.twig', array(
            'post' => $post,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction(Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);

        return $this->render('BlogBundle:post:show.html.twig', array(
            'post' => $post,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction(Request $request, Post $post)
    {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('create_edit', array('id' => $post->getId()));
        }

        return $this->render('BlogBundle:post:edit.html.twig', array(
            'post' => $post,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Post entity.
     *
     */
    public function deleteAction(Request $request, Post $post)
    {
        $form = $this->createDeleteForm($post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();
        }

        return $this->redirectToRoute('create_index');
    }

    /**
     * Creates a form to delete a Post entity.
     *
     * @param Post $post The Post entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Post $post)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('create_delete', array('id' => $post->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
