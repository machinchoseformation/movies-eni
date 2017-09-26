<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table(name="movie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MovieRepository")
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imdbId", type="string", length=20, unique=true)
     */
    private $imdbId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="cast", type="text")
     */
    private $cast;

    /**
     * @var string
     *
     * @ORM\Column(name="directors", type="text")
     */
    private $directors;

    /**
     * @var string
     *
     * @ORM\Column(name="writers", type="text")
     */
    private $writers;

    /**
     * @var string
     *
     * @ORM\Column(name="plot", type="text")
     */
    private $plot;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="float")
     */
    private $rating;

    /**
     * @var int
     *
     * @ORM\Column(name="votes", type="integer")
     */
    private $votes;

    /**
     * @var string
     *
     * @ORM\Column(name="runtime", type="string", length=25)
     */
    private $runtime;

    /**
     * @var string
     *
     * @ORM\Column(name="trailerId", type="string", length=100, nullable=true)
     */
    private $trailerId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateModified", type="datetime")
     */
    private $dateModified;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Genre", inversedBy="movies")
     */
    private $genres;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imdbId
     *
     * @param string $imdbId
     *
     * @return Movie
     */
    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;

        return $this;
    }

    /**
     * Get imdbId
     *
     * @return string
     */
    public function getImdbId()
    {
        return $this->imdbId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Movie
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set year
     *
     * @param integer $year
     *
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set cast
     *
     * @param string $cast
     *
     * @return Movie
     */
    public function setCast($cast)
    {
        $this->cast = $cast;

        return $this;
    }

    /**
     * Get cast
     *
     * @return string
     */
    public function getCast()
    {
        return $this->cast;
    }

    /**
     * Set directors
     *
     * @param string $directors
     *
     * @return Movie
     */
    public function setDirectors($directors)
    {
        $this->directors = $directors;

        return $this;
    }

    /**
     * Get directors
     *
     * @return string
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    /**
     * Set writers
     *
     * @param string $writers
     *
     * @return Movie
     */
    public function setWriters($writers)
    {
        $this->writers = $writers;

        return $this;
    }

    /**
     * Get writers
     *
     * @return string
     */
    public function getWriters()
    {
        return $this->writers;
    }

    /**
     * Set plot
     *
     * @param string $plot
     *
     * @return Movie
     */
    public function setPlot($plot)
    {
        $this->plot = $plot;

        return $this;
    }

    /**
     * Get plot
     *
     * @return string
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * Set rating
     *
     * @param float $rating
     *
     * @return Movie
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set votes
     *
     * @param integer $votes
     *
     * @return Movie
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
     * @return int
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Set runtime
     *
     * @param string $runtime
     *
     * @return Movie
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return string
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set trailerId
     *
     * @param string $trailerId
     *
     * @return Movie
     */
    public function setTrailerId($trailerId)
    {
        $this->trailerId = $trailerId;

        return $this;
    }

    /**
     * Get trailerId
     *
     * @return string
     */
    public function getTrailerId()
    {
        return $this->trailerId;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Movie
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     *
     * @return Movie
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Add genre
     *
     * @param \AppBundle\Entity\Genre $genre
     *
     * @return Movie
     */
    public function addGenre(\AppBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;

        return $this;
    }

    /**
     * Remove genre
     *
     * @param \AppBundle\Entity\Genre $genre
     */
    public function removeGenre(\AppBundle\Entity\Genre $genre)
    {
        $this->genres->removeElement($genre);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
