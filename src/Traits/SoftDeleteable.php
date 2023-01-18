<?php


namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait SoftDeleteable
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(mixed $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}
