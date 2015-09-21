<?php namespace Orchestra\Story\Policies;

use Orchestra\Story\Model\Content;
use Orchestra\Authorization\Policy;
use Illuminate\Contracts\Auth\Authenticatable;

class ContentPolicy extends Policy
{
    /**
     * Authorization driver name.
     *
     * @var string
     */
    protected $name = 'orchestra/story';

    /**
     * Create content policy.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return bool
     */
    public function create(Authenticatable $user, Content $content)
    {
        $type = $content->getAttribute('type');

        return $this->can("create {$type}") || $this->can("manage {$type}");
    }

    /**
     * Update content policy.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return bool
     */
    public function update(Authenticatable $user, Content $content)
    {
        $type  = $content->getAttribute('type');
        $owner = $content->ownedBy($user);

        return ($this->can("manage {$type}") || ($owner && $this->can("update {$type}")));
    }

    /**
     * Delete content policy.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return bool
     */
    public function delete(Authenticatable $user, Content $content)
    {
        $type  = $content->getAttribute('type');
        $owner = $content->ownedBy($user);

        return ($this->can("manage {$type}") || ($owner && $this->can("delete {$type}")));
    }

    /**
     * Manage content policy.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Orchestra\Story\Model\Content  $content
     *
     * @return bool
     */
    public function manage(Authenticatable $user, Content $content)
    {
        $type = $content->getAttribute('type');

        return $this->can("manage {$type}");
    }
}
