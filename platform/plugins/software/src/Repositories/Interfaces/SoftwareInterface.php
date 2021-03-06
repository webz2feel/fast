<?php


namespace Fast\Software\Repositories\Interfaces;
use Fast\Support\Repositories\Interfaces\RepositoryInterface;

interface SoftwareInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function getFeatured($limit = 5);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListSoftwareNonInList(array $selected = [], $limit = 7);

    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByCategory($categoryId, $paginate = 12, $limit = 0);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserId($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param int $tag
     * @param int $paginate
     * @return mixed
     */
    public function getByTag($tag, $paginate = 12);

    /**
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelatedSoftware($id, $limit = 3);

    /**
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getRecentSoftwares($limit = 5, $categoryId = 0);

    /**
     * @param  int  $limit
     *
     * @return mixed
     */
    public function getTopDownloadsSoftware($limit = 7);

    /**
     * @param  int  $limit
     *
     * @return mixed
     */
    public function getLatestDownloadsSoftware($limit = 5);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearch($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllSoftwares($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularSoftwares($limit, array $args = []);

    /**
     * @param \Eloquent|int $model
     * @return array
     */
    public function getRelatedCategoryIds($model);
}
