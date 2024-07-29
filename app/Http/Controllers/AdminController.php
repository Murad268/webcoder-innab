<?php

namespace App\Http\Controllers;

use Modules\Project\Repositories\ModelRepository as ProjectRepository;
use Modules\Customer\Repositories\ModelRepository as CustomerRepository;
use Modules\Partners\Repositories\ModelRepository as PartnersRepository;
use Modules\BlogContent\Repositories\ModelRepository as BlogContentRepository;
use Modules\VideoLessons\Repositories\ModelRepository as VideoLessonsRepository;
use Modules\Training\Repositories\ModelRepository as TrainingRepository;
use Modules\Vebinar\Repositories\ModelRepository as VebinarRepository;
use Modules\Workshop\Repositories\ModelRepository as WorkshopRepository;
use Modules\ScholarshipProgram\Repositories\ModelRepository as ProgramRepository;

class AdminController extends Controller
{
    public function __construct(
        public ProjectRepository $projectRepository,
        public CustomerRepository $customerRepository,
        public PartnersRepository $partnersRepository,
        public BlogContentRepository $blogContentRepository,
        public VideoLessonsRepository $videoLessonsRepository,
        public TrainingRepository $trainingRepository,
        public VebinarRepository $vebinarRepository,
        public WorkshopRepository $workshopRepository,
        public ProgramRepository $programRepository
    ) {
    }

    public function index()
    {
        return view('dashboard.index', [
            'projectRepository' => $this->projectRepository,
            'customerRepository' => $this->customerRepository,
            'partnersRepository' => $this->partnersRepository,
            'blogContentRepository' => $this->blogContentRepository,
            'videoLessonsRepository' => $this->videoLessonsRepository,
            'trainingRepository' => $this->trainingRepository,
            'vebinarRepository' => $this->vebinarRepository,
            'workshopRepository' => $this->workshopRepository,
            'programRepository' => $this->programRepository,
        ]);
    }
}
