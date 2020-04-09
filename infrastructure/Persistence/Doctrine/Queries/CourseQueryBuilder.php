<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Queries;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\QueryBuilder;
use Domain\Entities\Category;
use Domain\Entities\CategoryCourse;
use Domain\Entities\Course;
use Domain\Entities\Tag;

class CourseQueryBuilder extends EntityRepository
{
    /**
     * @var QueryBuilder
     */
    private $dqlQuery;

    private $courses = [];
    private $filteredCourses = [];

    public function __construct(EntityManager $em)
    {
        parent::__construct($em, new Mapping\ClassMetadata(Course::class));
        $this->init();
    }

    /**
     * @param string $query
     * @return CourseQueryBuilder
     */
    public function byQuery(string $query): CourseQueryBuilder
    {
        $this->dqlQuery->where('c.name LIKE :query')
            ->orWhere('c.description LIKE :query')
            ->setParameter('query', '%' . $query . '%');

        $this->filteredCourses = $this->dqlQuery->getQuery()->getResult();

        return $this;
    }

    /**
     * @param Collection $tags
     * @return CourseQueryBuilder
     */
    public function byTags(Collection $tags): CourseQueryBuilder
    {
        $this->courses = $this->filteredCourses;
        $this->filteredCourses = [];

        if (!$this->courses) {
            $this->courses = $this->dqlQuery->getQuery()->getResult();
        }

        foreach ($this->courses as $course) {
            $courseTags = $course->getTags()->getValues();
            $courseTagsNames = array_map(function ($courseTag) {
                return $courseTag->getName();
            }, $courseTags);

            $hasAllTag = true;

            foreach ($tags as $tag) {
                if (!in_array($tag, $courseTagsNames)) {
                    $hasAllTag = false;
                }
            }

            if ($hasAllTag) {
                $this->filteredCourses[] = $course;
            }
        }
        return $this;
    }

    /**
     * @param Collection $categories
     * @return CourseQueryBuilder
     */
    public function byCategories(Collection $categories): CourseQueryBuilder
    {
        $this->courses = $this->filteredCourses;
        $this->filteredCourses = [];

        if (!$this->courses) {
            $this->courses = $this->dqlQuery->getQuery()->getResult();
        }

        foreach ($this->courses as $course) {
            $courseCategories = $course->getCategories()->getValues();
            $courseCategoriesNames = array_map(function ($courseCategory) {
                return $courseCategory->getName();
            }, $courseCategories);

            $hasAllCategories = true;

            foreach ($categories as $category) {
                if (!in_array($category, $courseCategoriesNames)) {
                    $hasAllCategories = false;
                }
            }

            if ($hasAllCategories) {
                $this->filteredCourses[] = $course;
            }
        }
        return $this;
    }

    /**
     * @return void
     */
    public function init()
    {
        $this->dqlQuery = $this->createQueryBuilder('c');
    }

    /**
     * @return array
     */
    public function executeQueryBuilder(): array
    {
        return $this->filteredCourses;
    }
}
