<?php
/**
 * Created by PhpStorm.
 * User: Ross
 * Date: 12.10.2020
 * Time: 10:05
 */

namespace App\Controller\Courses;

use App\Entity\Lesson;
use App\Entity\Section;
use App\Entity\Supportfiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SectionController extends AbstractController
{
    /**
     * @Route("lessons/{lesson}", name="sections", requirements={"lesson"="\d+"})
     */
    public function indexAction(Lesson $lesson){
        $lessons = $this->getDoctrine()->getRepository(Lesson::class)->findBy(['module'=>$lesson->getModule()], ['id'=>'asc']);
        $sections = $this->getDoctrine()->getRepository(Section::class)->findBy(['lesson'=>$lesson], ['id'=>'asc']);
        $supportFiles = $this->getDoctrine()->getRepository(Supportfiles::class)->findBy(['lesson'=>$lesson], ['id'=>'asc']);
        return $this->render("courses/lesson.html.twig", array(
            "sections" => $sections,
            "lesson" => $lesson,
            "supportFiles" => $supportFiles,
            "lessons" => $lessons,
        ));
    }

    /**
     * @Route("lessons/{lesson}/sections/new", name="new_section", requirements={"lesson"="\d+"})
     */
    public function newSectionAction(Request $request, Lesson $lesson){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;
        $paragraph = $post->get("paragraph");

        if($paragraph == ''){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Renseignez le contenu de cette section"
            ));
        }
        $section = new Section();
        $section->setParagraph($paragraph)
            ->setLesson($lesson);

        if($request->files->get('image')){
            try{
                $imagePath= $this->uploadImage($request->files->get('image'));
                $section->setImage($imagePath);
            }catch (\Exception $e){
                return new JsonResponse(array("status"=>1, "mes"=>"Une erreur est survenue lors du chargement de l'image"));
            }
        }
        $em->persist($section);
        $em->flush();

        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Section ajoutée avec succès"
        ));
    }

    /**
     * @Route("lessons/{lesson}/sections/{section}/edit", name="edit_section", requirements={"lesson"="\d+", "section"="\d+"})
     */
    public function editSectionAction(Request $request, Lesson $lesson, Section $section){

        $em = $this->getDoctrine()->getManager();
        $post = $request->request;
        $paragraph = $post->get("paragraph");

        if($paragraph == ''){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Renseignez le contenu de cette section"
            ));
        }
        $section->setParagraph($paragraph);

        if($request->files->get('image')){
            try{
                $imagePath= $this->uploadImage($request->files->get('image'));
                $this->removeFile($this->getParameter("images_courses_directory").$section->getImage());
                $section->setImage($imagePath);
            }catch (\Exception $e){
                return new JsonResponse(array("status"=>1, "mes"=>"Une erreur est survenue lors du chargement de l'image"));
            }
        }
        $em->persist($section);
        $em->flush();

        return new JsonResponse(array(
            "status"=>0,
            "mes"=>"Section modifiée avec succès"
        ));
    }


    /**
     * @Route("lessons/{lesson}/sections/{section}/delete", name="delete_section", requirements={"lesson"="\d+", "section"="\d+"})
     */
    public function deleteSectionAction(Lesson $lesson, Section $section){

        $em = $this->getDoctrine()->getManager();
        $em->remove($section);
        try{
            $em->flush();
            $this->removeFile($this->getParameter("images_courses_directory").$section->getImage());
            return new JsonResponse(array(
                "status"=>0,
                "mes"=>"Section supprimée avec succès"
            ));
        }catch (\Exception $e){
            return new JsonResponse(array(
                "status"=>1,
                "mes"=>"Impossible de supprimer cette leçon"
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


    private function removeFile($path){
        if(file_exists($path) && fileperms($path) == 0)
            unlink($path);
    }

    private function getUniqueFileName(){
        return md5(uniqid());
    }
}