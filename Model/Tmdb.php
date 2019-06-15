<?php

/**
 * Class Model for Tmdb class
 *
 * @package Mundipagg\Tmdb\Model\Tmdb
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Model;

use Mundipagg\Tmdb\Api\Data\TmdbInterface;

class Tmdb implements TmdbInterface
{
    /**
     * @var array
     */
    private $movie;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->movie[TmdbInterface::TITLE];
    }

    /**
     * @param string $title
     * @return TmdbInterface
     */
    public function setTitle(string $title): TmdbInterface
    {
        $this->movie[TmdbInterface::TITLE] = $title;
        return $this;
    }


    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->movie[TmdbInterface::DESCRIPTION];
    }

    /**
     * @param string $description
     * @return TmdbInterface
     */
    public function setDescription(string $description): TmdbInterface
    {
        $this->movie[TmdbInterface::DESCRIPTION] = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movie[TmdbInterface::MOVIE_ID];
    }

    /**
     * @param int $movie_id
     * @return TmdbInterface
     */
    public function setMovieId(int $movie_id): TmdbInterface
    {
        $this->movie[TmdbInterface::MOVIE_ID] = $movie_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->movie[TmdbInterface::IMAGE_URL];
    }

    /**
     * @param string $image_url
     * @return TmdbInterface
     */
    public function setImageUrl(string $image_url): TmdbInterface
    {
        $this->movie[TmdbInterface::IMAGE_URL] = $image_url;
        return $this;
    }

    /**
     * @return array
     */
    public function getTmdb(): array
    {
        return $this->movie;
    }

    /**
     * @param stdClass $movie
     * @return TmdbInterface
     */
    public function setTmdb($movie): TmdbInterface
    {
        $this->setTitle($movie->title);
        $this->setDescription($movie->overview);
        $this->setMovieId($movie->id);
        $this->setImageUrl($movie->poster_path);
        return $this;
    }
}