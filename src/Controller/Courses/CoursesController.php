<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 07:42
 */

namespace App\Controller\Courses;


use App\Entity\Courses;
use App\Entity\Inscription;
use App\Tools\Thumbnails;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends  AbstractController
{
    /**
     * @Route("/courses", name="courses")
     */
    public function indexAction(Request $request, PaginatorInterface $paginator){
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository(Courses::class)->findBy([], ['createdat'=>'desc']);
        $pagination = $paginator->paginate(
            $courses,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('courses/index.html.twig', array("pagination" =>$pagination));
    }

    /**
     * @Route("/courses/{course}/participants", name="users_courses", requirements={"course"="\d+"})
     */
    public function usersAction(Request $request, PaginatorInterface $paginator, Courses $course){
        $em = $this->getDoctrine()->getManager();
        $subscriptions = $em->getRepository(Inscription::class)->findBy(["courses"=>$course], ['createdat'=>'desc']);
        $pagination = $paginator->paginate(
            $subscriptions,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('courses/participants.html.twig', array("pagination" =>$pagination, "course"=>$course));
    }

    /**
     * @Route("/courses/new", name="new_course")
     */
    public function newCoursAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $course = new Courses();
        $course = $this->validateForm($request, $course);
        if(get_class($course) != Courses::class)
            return $course;

        if(!$request->files->get('photo'))
            return new JsonResponse(['status'=>1, 'mes'=>'Ajoutez l`\'image d\'introduction de la formation']);
        try{
            $photo = $this->uploadImage($request->files->get('photo'));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>$e->getMessage()
            ));
        }

        $course->setImage($photo);
        $em->persist($course);
        $em->flush();
        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Formation ajout??e avec succ??s"
        ));
    }

    /**
     * @Route("/courses/{course}/edit", name="edit_course", requirements={"course"="\d+"})
     */
    public function editCoursAction(Request $request, Courses $course){

        $em = $this->getDoctrine()->getManager();
        $course = $this->validateForm($request, $course);
        if(get_class($course) != Courses::class)
            return $course;

        try{
            if($request->files->get('photo')){
                $photo = $this->uploadImage($request->files->get('photo'));
                $this->removeFile($this->getParameter("images_courses_directory").$course->getImage());
                $course->setImage($photo);
            }
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>$e->getMessage(),
            ));
        }

        $em->persist($course);
        $em->flush();
        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Formation ??dit??e avec succ??s"
        ));
    }

    /**
     * @Route("/courses/{course}/delete", name="delete_course", requirements={"course"="\d+"})
     */
    public function deleteCoursAction(Courses $course){

        $em = $this->getDoctrine()->getManager();
        $em->remove($course);
        try{
            $em->flush();
            $this->removeFile($this->getParameter("images_courses_directory").$course->getImage());
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Formation supprim??e avec succ??s"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue, reessayez plutard.",
                "error"=>$e->getMessage(),
            ));
        }
    }

    /**
     * @Route("/courses/{course}/publish", name="publish_course", requirements={"course"="\d+"})
     */
    public function publishAction(Request $request, Courses $course){
        $em = $this->getDoctrine()->getManager();
        $publish = $request->request->get('publish');
        if($publish == null)
            return new JsonResponse(array("status"=>1, "mes"=>"Une erreur est survenue"));

        $course->setIsPublished($publish);
        $em->persist($course);
        try{
            $em->flush();
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>$course->isPublished()? "Formation publi??e" : "Formation d??sactiv??e avec succ??s"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Une erreur est survenue, reessayez plutard.",
                "error"=>$e->getMessage(),
            ));
        }
    }

    private function validateForm(Request $request, Courses $course){
        $post = $request->request;
        $title = $post->get("title");
        $price = $post->get("price");
        $oldPrice = $post->get("oldPrice", 0);
        $overview = $post->get("overview", 0);
        $duration = $post->get("duration", "");
        $video = $post->get("video", "");
        $isPublished = $post->get("isPublished", false);
        $metaDescription = $post->get("metaDescription");
        $metaUrl = $post->get("metaUrl");

        $metaUrl = $this->titleToUrl($metaUrl??$title);
        if($title == "")
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez le titre de la formation"));
        if( $overview == "")
            return new JsonResponse(array("status"=>1, "mes"=>"Ajoutez une description ?? la formation"));
        if( $price == 0)
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez le prix de la formation"));
        if( $oldPrice != 0 && $oldPrice > 0 && $oldPrice < $price)
            return new JsonResponse(array("status"=>1, "mes"=>"L'ancien prix doit ??tre sup??rieur au nouveau"));
        if( $duration == "")
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez la dur??e de la formation (en Heure)"));
        if( $video == "")
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez la vid??o d'introduction"));
        if( $metaDescription == "")
            return new JsonResponse(array("status"=>1, "mes"=>"Renseignez une meta description (tr??s important pour le SEO)"));
        if($oldPrice == "")
            $oldPrice = null;
        return $this->saveCourses(
            $course,$title, $price, $oldPrice,
            $overview, $duration, $video,
            $isPublished, $metaDescription, $metaUrl
        );
    }

    private function saveCourses(Courses $course,$title, $price, $oldPrice, $overview,
                                 $duration, $video, $isPublished, $metaDescription, $metaUrl): Courses{

        $course->setTitle($title);
        $course->setPrice($price);
        $course->setOldprice($oldPrice);
        $course->setOverview($overview);
        $course->setDuration($duration);
        $course->setVideo($video);
        $course->setIsPublished($isPublished);
        $course->setMetaDescription($metaDescription);
        $course->setMetaUrl($metaUrl);
        if($course->getId() > 0) {
            $course->setNblesson(0);
            $course->setNbreview(0);
        }
        return $course;
    }

    private function titleToUrl($title){
        $title = trim($title);
        $replaces = ['&', '_', ' ', "\\", "/"];
        $title = str_replace($replaces,"-", $title);
        $replaces = [":", "?", "#", "[", "]", "@", "!", "$", "&", "'", "(", ")", "*", "+", ",", ";", "=", '"'];
        return strtolower(str_replace($replaces,"-", $title));
    }

    /**
     * @param UploadedFile $file
     * @throws \Exception
     */
    private function uploadImage(UploadedFile $file) {
        $imageAccepted = array("jpg", "png", "jpeg");
        if( in_array(strtolower($file->guessExtension()), $imageAccepted) ){
            $fileName = $this->getUniqueFileName($file->guessExtension());
            $thumbnailsFileName = $this->getUniqueFileName($file->guessExtension());
            $file->move($this->getParameter("images_courses_directory"), $fileName);
            $result = Thumbnails::createThumbnail(
                $this->getParameter("images_courses_directory").$thumbnailsFileName,
                $this->getParameter("images_courses_directory").$fileName,
                300
            );
            if($result == Thumbnails::COMPRESSION_SUCCESS)
                return $thumbnailsFileName;
            elseif($result == Thumbnails::COMPRESSION_ERROR)
                throw new \Exception("Un probl??me est survenu lors de la compression de l'image", 100);
            else
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
            $fileName = $this->getUniqueFileName($file->guessExtension());
            $file->move($this->getParameter("videos_courses_directory"), $fileName);
            return $fileName;
        }else{
            throw new \Exception("Format de vid??o incorrect", 100);
        }
    }

    private function removeFile($path){
        if(file_exists($path) && fileperms($path) == 0)
            unlink($path);
    }

    private function getUniqueFileName($extension=null){
        return md5(uniqid()).($extension==null? "" : ".".$extension);
    }

}