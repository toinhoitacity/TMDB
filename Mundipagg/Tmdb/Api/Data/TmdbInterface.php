<?php

/**
 * Interface for Tmdb class
 *
 * @package Mundipagg\Tmdb\Service\ImportImageService
 * @author Antonio Gutierrez <gutierrez.computacao@gmail.com>
 * @version 1.0.0
 */
namespace Mundipagg\Tmdb\Api\Data;


interface TmdbInterface
{
    const TITLE = 'title';
    const PRICE = 'price';
    const DESCRIPTION = 'description';
    const MOVIE_ID = 'movie_id';
    const IMAGE_URL = 'image_url';

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @param string $title
     * @return TmdbInterface
     */
    public function setTitle(string $title): TmdbInterface;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @param string $description
     * @return TmdbInterface
     */
    public function setDescription(string $description): TmdbInterface;

    /**
     * @return int
     */
    public function getMovieId(): int;

    /**
     * @param int $movie_id
     * @return TmdbInterface
     */
    public function setMovieId(int $movie_id): TmdbInterface;

    /**
     * @return string
     */
    public function getImageUrl(): string;

    /**
     * @param string $image_url
     * @return TmdbInterface
     */
    public function setImageUrl(string $image_url): TmdbInterface;

    /**
     * @return array
     */
    public function getTmdb(): array;

    /**
     * @param stdClass $movie
     * @return TmdbInterface
     */
    public function setTmdb($movie): TmdbInterface;
}