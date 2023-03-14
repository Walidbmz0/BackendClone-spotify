<?php

namespace App\Entity;

use App\Repository\PlaylistSongRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSongRepository::class)]
class PlaylistSong
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $playlist = null;

    #[ORM\ManyToOne(inversedBy: 'playlistSongs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?song $song = null;

    #[ORM\OneToMany(mappedBy: 'playlists', targetEntity: Song::class)]
    private Collection $songs;

    public function __construct()
    {
        $this->songs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaylist(): ?int
    {
        return $this->playlist;
    }

    public function setPlaylist(int $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getSong(): ?song
    {
        return $this->song;
    }

    public function setSong(?song $song): self
    {
        $this->song = $song;

        return $this;
    }

    /**
     * @return Collection<int, Song>
     */
    public function getSongs(): Collection
    {
        return $this->songs;
    }

    public function addSong(Song $song): self
    {
        if (!$this->songs->contains($song)) {
            $this->songs->add($song);
            $song->setPlaylists($this);
        }

        return $this;
    }

    public function removeSong(Song $song): self
    {
        if ($this->songs->removeElement($song)) {
            // set the owning side to null (unless already changed)
            if ($song->getPlaylists() === $this) {
                $song->setPlaylists(null);
            }
        }

        return $this;
    }
}
