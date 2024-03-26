<?php

declare(strict_types=1);

namespace Model\Entity;

use Dibi\DateTime;
use LeanMapper\Entity;

/**
 * @property int $id
 * @property string|null $name
 *
 * @property DateTime|null $inserted
 * @property DateTime|null $updated
 * @property DateTime|null $deleted
 */
class Tag extends Entity
{

}

