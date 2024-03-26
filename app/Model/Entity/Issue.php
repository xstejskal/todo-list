<?php

declare(strict_types=1);

namespace Model\Entity;

use Dibi\DateTime;
use LeanMapper\Entity;

/**
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property bool $done
 *
 * @property DateTime|null $inserted
 * @property DateTime|null $updated
 * @property DateTime|null $deleted
 *
 * @property Tag[] $tags m:hasMany
 */
class Issue extends Entity
{

}

