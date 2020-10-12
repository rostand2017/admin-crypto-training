<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 07:42
 */

namespace App\Controller\Courses;


use App\Entity\Course;
use App\Entity\Subcription;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CoursesController extends  AbstractController
{
    /**
     * @Route("/courses", name="courses")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator){
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository(Course::class)->findBy([], ['createdAt'=>'desc']);
        $pagination = $paginator->paginate(
            $courses,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('courses/index.html.twig', array("pagination" =>$pagination));
    }

    /**
     * @Route("/courses/{course}/participants", name="courses", requirements={"course"="\d+"})
     */
    public function usersAction(Request $request, PaginatorInterface $paginator, Course $course){
        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository(Subcription::class)->findBy(["course"=>$course], ['createdAt'=>'desc']);
        $pagination = $paginator->paginate(
            $subscriptions,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('courses/participants.html.twig', array("pagination" =>$pagination));
    }

    /**
     * @Route("/categories/new", name="new_course")
     */
    public function newCoursAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;

        $title = $post->get("title");
        $description = $post->get("description");
        $price = $post->get("price");

        if($title == '' || $description == '' || $price < 0){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Renseignez tous les différents champs"
            ));
        }

        if(!$request->files->get('photo') || !$request->files->get('video'))
            return new JsonResponse(['status'=>1, 'mes'=>'Ajoutez la vidéo(ou l`\'image) d\'introduction du cours']);


        try{
            $photo = $this->uploadImage($request->files->get('photo'));
            $video= $this->uploadVideo($request->files->get('video'));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue lors du chargement de la vidéo/image"
            ));
        }

        $course = new Course();
        $course->setTitle($title);
        $course->setPrice($price);
        $course->setDescription($description);
        $course->setPhoto($photo)
            ->setVideo($video);
        $em->persist($course);
        $em->flush();
        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Cours ajouté avec succès"
        ));
    }

    /**
     * @Route("/categories/{course}/edit", name="edit_course", requirements={"course"="\d+"})
     */
    public function editCoursAction(Request $request, Course $course){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;

        $title = $post->get("title");
        $description = $post->get("description");
        $price = $post->get("price");

        if($title == '' || $description == '' || $price < 0){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Renseignez tous les différents champs"
            ));
        }

        try{
            if(!$request->files->get('photo')){
                $photo = $this->uploadImage($request->files->get('photo'));
                $this->removeFile($this->getParameter("images_courses_directory").$course->getPhoto());
                $course->setPhoto($photo);
            }

            if(!$request->files->get('video')){
                $video = $this->uploadVideo($request->files->get('video'));
                $this->removeFile($this->getParameter("videos_courses_directory").$course->getVideo());
                $course->setPhoto($video);
            }
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue lors du chargement de la vidéo/image"
            ));
        }

        $course->setTitle($title);
        $course->setPrice($price);
        $course->setDescription($description);
        $em->persist($course);
        $em->flush();
        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Cours modifié avec succès"
        ));
    }

    /**
     * @Route("/categories/{course}/delete", name="delete_course", requirements={"course"="\d+"})
     */
    public function deleteCoursAction(Course $course){

        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        try{
            $em->flush();
            $this->removeFile($this->getParameter("videos_courses_directory").$course->getVideo());
            $this->removeFile($this->getParameter("images_courses_directory").$course->getPhoto());
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Cours supprimé avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue, reessayé plutard."
            ));
        }
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadImage(UploadedFile $file) {
        $imageAccepted = array("jpg", "png", "jpeg");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName().".".$file->guessExtension();
            $file->move($this->getParameter("images_courses_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format d'image incorrect", 100);
        }
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadVideo(UploadedFile $file){
        $imageAccepted = array("mp4", "avi");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName().".".$file->guessExtension();
            $file->move($this->getParameter("videos_courses_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format de vidéo incorrect", 100);
        }
    }

    private function removeFile($path){
        if(file_exists($path))
            unlink($path);
    }

    private function getUniqueFileName(){
        return md5(uniqid());
    }

}